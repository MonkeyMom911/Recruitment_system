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
        $recentApplications = Application::with(['user', 'jobVacancy'])->whereIn('job_vacancy_id', $hrdJobVacancyIds)->latest()->take(5)->get();
         // 1. [FIX] Calculate interviews scheduled for today
        $interviewsTodayCount = ApplicationStage::whereHas('application', function ($query) use ($hrdJobVacancyIds) {
                $query->whereIn('job_vacancy_id', $hrdJobVacancyIds);
            })
            ->whereDate('scheduled_date', now())
            ->count();

        // 2. [FIX] Get upcoming interviews (can include today's)
        $upcomingInterviews = ApplicationStage::with(['application.user', 'application.jobVacancy'])
            ->whereHas('application', function ($query) use ($hrdJobVacancyIds) {
                $query->whereIn('job_vacancy_id', $hrdJobVacancyIds);
            })
            ->where('scheduled_date', '>=', now())
            ->orderBy('scheduled_date', 'asc')
            ->take(5)
            ->get();

        // 3. [FIX] Change data format for the status chart
        $applicationStatuses = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get(); // Changed from pluck() to get() for correct array structure

        // 4. [NEW] Add data for Weekly Applications chart
        $weeklyApplicationsData = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->where('created_at', '>=', now()->subDays(6))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // 5. [NEW] Add data for Monthly Applications chart
        $monthlyApplications = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->where('created_at', '>=', now()->startOfYear()) // Fetches data for the current year
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();


        // Pass all variables to the view
        return view('hrd.dashboard', compact(
            'activeVacancies',
            'totalApplications',
            'applicationsLast7Days',
            'recentApplications',
            'interviewsTodayCount',      // <-- Added
            'upcomingInterviews',
            'applicationStatuses',       // <-- Format updated
            'weeklyApplicationsData',    // <-- Added
            'monthlyApplications'        // <-- Added
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

    public function interviewsIndex()
    {
        $hrdId = auth()->id();
        $hrdJobVacancyIds = JobVacancy::where('created_by', $hrdId)->pluck('id');

        // Fetch all interviews (upcoming and past), ordered by the most recent schedule
        $interviews = ApplicationStage::with(['application.user', 'application.jobVacancy'])
            ->whereHas('application', function ($query) use ($hrdJobVacancyIds) {
                $query->whereIn('job_vacancy_id', $hrdJobVacancyIds);
            })
            ->whereNotNull('scheduled_date')
            ->orderBy('scheduled_date', 'desc') // Show most recent first
            ->paginate(20); // Use pagination for long lists

        // The view file we will create in the next step
        return view('hrd.interviews.index', compact('interviews'));
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