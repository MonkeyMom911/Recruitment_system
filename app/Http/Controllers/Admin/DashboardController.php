<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;
use App\Exports\JobVacanciesExport;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Count statistics
        $totalUsers = User::count();
        $totalVacancies = JobVacancy::count();
        $totalApplications = Application::count();
        $activeVacancies = JobVacancy::where('status', 'active')->count();
        
        
        $weeklyApplicationsData = Application::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Role statistics
        $userRoles = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();
        
        // Application status statistics
        $applicationStatuses = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        // Monthly application statistics (for the past 6 months)
        $monthlyApplications = Application::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        // Recent applications
        $recentApplications = Application::with(['user', 'jobVacancy'])
            ->latest()
            ->take(5)
            ->get();

        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $newUsersThisMonth = User::where('created_at', '>=', $thisMonth)->count();
        $newUsersLastMonth = User::whereBetween('created_at', [$lastMonth, $thisMonth])->count();
        
        $userGrowth = 0;
            if ($newUsersLastMonth > 0) {
                $userGrowth = (($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100;
            } elseif ($newUsersThisMonth > 0) {
                $userGrowth = 100;
            }

        $applicationsLast7Days = Application::where('created_at', '>=', now()->subDays(7))->count();

        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalVacancies',
            'totalApplications',
            'activeVacancies',
            'userRoles',
            'applicationStatuses',
            'monthlyApplications',
            'recentApplications',
            'userGrowth',
            'applicationsLast7Days',  
            'weeklyApplicationsData' 
        ));
    }
    
    public function applicationsReport(Request $request)
    {
        $query = Application::with(['user', 'jobVacancy']);
        
        // Filter by date range
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by job vacancy
        if ($request->filled('job_vacancy_id')) {
            $query->where('job_vacancy_id', $request->job_vacancy_id);
        }
        
        $applications = $query->latest()->paginate(20);
        $jobVacancies = JobVacancy::pluck('title', 'id');
        
        return view('admin.reports.applications', compact('applications', 'jobVacancies'));
    }
    
    public function jobVacanciesReport(Request $request)
    {
        $query = JobVacancy::withCount('applications');
        
        // Filter by date range
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        $jobVacancies = $query->latest()->paginate(20);
        $departments = JobVacancy::select('department')->distinct()->pluck('department');
        
        return view('admin.reports.job-vacancies', compact('jobVacancies', 'departments'));
    }
    
    public function exportReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:applications,job_vacancies',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        $reportType = $request->report_type;
        $fileName = $reportType . '_report_' . now()->format('Y-m-d') . '.xlsx';
        
        if ($reportType === 'applications') {
            return Excel::download(new ApplicationsExport($request->all()), $fileName);
        } else {
            return Excel::download(new JobVacanciesExport($request->all()), $fileName);
        }
    }
}
