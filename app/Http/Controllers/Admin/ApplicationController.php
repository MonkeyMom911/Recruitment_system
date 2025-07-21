<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\SelectionStage;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Notifications\ApplicationStatusUpdated;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['user', 'jobVacancy']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by job vacancy
        if ($request->filled('job_vacancy_id')) {
            $query->where('job_vacancy_id', $request->job_vacancy_id);
        }
        
        // Filter by date range
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        // Search by applicant name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        $applications = $query->latest()->paginate(15);
        $jobVacancies = JobVacancy::pluck('title', 'id');

        $statusCounts = Application::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();
        $applicationsCount = Application::count();

        return view('admin.applications.index', compact(
        'applications',
        'jobVacancies',
        'statusCounts',
        'applicationsCount'
    ));
    }

    public function show(Application $application)
    {
        $application->load(['user.profile', 'jobVacancy', 'documents', 'stages.selectionStage']);
        
        return view('admin.applications.show', compact('application'));
    }

    public function destroy(Application $application)
    {
        // Delete related files
        if ($application->cv_path) {
            Storage::disk('public')->delete($application->cv_path);
        }
        
        foreach ($application->documents as $document) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $application->delete();
        
        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted successfully.');
    }

    public function updateStatus(Request $request, Application $application)
    {
    $request->validate([
        'status' => 'required|in:screening,interview,test,hired,rejected',
    ]);

    $oldStatus = $application->status;
    $application->status = $request->status;
    $application->save();

     $application->user->notify(new ApplicationStatusUpdated($application, $oldStatus));

    if (in_array($request->status, ['screening', 'interview', 'test'])) {
        
        $stageId = SelectionStage::where('code', $request->status)->value('id');

        if ($stageId) {
            
            $application->stages()->create([
                'selection_stage_id' => $stageId,
                'status' => 'completed', 
            ]);
        }
    }

    return redirect()->back()->with('success', 'Application status updated to ' . ucfirst($request->status) . '.');
    }

}
