<?php

namespace App\Http\Controllers\HRD;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Application;
use App\Models\ApplicationStage;
use App\Exports\ApplicationsExport;
use App\Exports\JobVacanciesExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $hrdId = auth()->id();
        $hrdJobVacancyIds = JobVacancy::where('created_by', $hrdId)->pluck('id');

        $totalVacancies = $hrdJobVacancyIds->count();
        $activeVacancies = JobVacancy::whereIn('id', $hrdJobVacancyIds)->where('status', 'active')->count();
        $totalApplications = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)->count();
        $applicationsLast7Days = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $upcomingInterviews = ApplicationStage::whereHas('application', function ($query) use ($hrdJobVacancyIds) {
            $query->whereIn('job_vacancy_id', $hrdJobVacancyIds);
        })->whereNotNull('scheduled_date')->where('scheduled_date', '>=', now())->orderBy('scheduled_date')->take(5)->get();
        $recentApplications = Application::with(['user', 'jobVacancy'])->whereIn('job_vacancy_id', $hrdJobVacancyIds)->latest()->take(5)->get();
        $applicationStatuses = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->pluck('count', 'status');

        return view('hrd.dashboard', compact(
            'totalVacancies',
            'activeVacancies',
            'totalApplications',
            'applicationsLast7Days',
            'upcomingInterviews',
            'recentApplications',
            'applicationStatuses'
        ));
    }

    // [FUNGSI BARU] Menampilkan Laporan Lamaran
    public function applicationsReport(Request $request)
    {
        $hrdId = auth()->id();
        $hrdJobVacancyIds = JobVacancy::where('created_by', $hrdId)->pluck('id');

        // [FIX] Mengubah 'applicant' menjadi 'user' agar sesuai dengan nama relasi di Model
        $query = Application::with('jobVacancy', 'user') 
            ->whereIn('job_vacancy_id', $hrdJobVacancyIds); // Filter berdasarkan lowongan HRD

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(20);

        return view('hrd.reports.applications', compact('applications'));
    }
    
    // [FUNGSI BARU] Menampilkan Laporan Lowongan Kerja
    public function jobVacanciesReport(Request $request)
    {
        $hrdId = auth()->id();
        $query = JobVacancy::withCount('applications')
            ->where('created_by', $hrdId); // Filter berdasarkan lowongan HRD

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobVacancies = $query->latest()->paginate(20);

        return view('hrd.reports.job-vacancies', compact('jobVacancies'));
    }

    // [FUNGSI BARU] Mengekspor Laporan
    public function exportReport(Request $request)
    {
        $type = $request->query('type', 'applications');
        $fileName = $type . '_report_' . now()->format('Y-m-d') . '.xlsx';

        if ($type === 'applications') {
            return Excel::download(new ApplicationsExport($request->all(), auth()->id()), $fileName);
        }

        if ($type === 'job-vacancies') {
            return Excel::download(new JobVacanciesExport($request->all(), auth()->id()), $fileName);
        }

        return redirect()->back()->with('error', 'Invalid report type.');
    }
}