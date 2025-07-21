<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicantController extends Controller
{
    use AuthorizesRequests;
    public function dashboard()
    {
        $user = auth()->user();
        $applications = $user->applications()->with('jobVacancy')->latest()->take(5)->get();
        $activeApplications = $user->applications()->whereNotIn('status', ['hired', 'rejected'])->count();
        $totalApplications = $user->applications()->count();
        
        return view('applicant.dashboard', compact('applications', 'activeApplications', 'totalApplications'));
    }

    public function applications()
    {
        $applications = auth()->user()->applications()
            ->with('jobVacancy', 'stages.selectionStage')
            ->latest()
            ->paginate(10);
        
        return view('applicant.applications.index', compact('applications'));
    }

    public function applicationShow(Application $application)
    {
        $this->authorize('view', $application);
        
        $application->load(['jobVacancy', 'documents', 'stages.selectionStage']);
        
        return view('applicant.applications.show', compact('application'));
    }
    
}

