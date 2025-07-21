<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use App\Models\ApplicationDocument;
use App\Models\ApplicationStage;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\NewApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ApplicationController extends Controller
{
    public function create(JobVacancy $jobVacancy)
    {
        if (!$jobVacancy->isActive()) {
            abort(404, 'Job vacancy is no longer active');
        }

        // Check if user has already applied
        $existingApplication = Application::where('user_id', auth()->id())
            ->where('job_vacancy_id', $jobVacancy->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('applicant.applications.show', $existingApplication)
                ->with('info', 'You have already applied for this position.');
        }

        return view('applications.create', compact('jobVacancy'));
    }

    public function store(Request $request, JobVacancy $jobVacancy)
    {
        $request->validate([
            'cover_letter' => 'required|string|min:50',
            'expected_salary' => 'required|numeric|min:0',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'additional_documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);


        // Check if user has already applied
        $existingApplication = Application::where('user_id', auth()->id())
            ->where('job_vacancy_id', $jobVacancy->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('applicant.applications.show', $existingApplication)
                ->with('info', 'You have already applied for this position.');
        }

        // Upload CV
        $cvFile = $request->file('cv');
        $cvName = time() . '_' . $cvFile->getClientOriginalName();
        $cvPath = $cvFile->storeAs('applications/cv', $cvName, 'public');

        // Create application
        $application = Application::create([
            'user_id' => auth()->id(),
            'job_vacancy_id' => $jobVacancy->id,
            'cv_path' => $cvPath,
            'cover_letter' => $request->cover_letter,
            'expected_salary' => $request->expected_salary,
        ]);

        // Upload additional documents
        if ($request->hasFile('additional_documents')) {
            foreach ($request->file('additional_documents') as $key => $documentFile) {
                $docType = $request->document_types[$key] ?? 'other';
                $docName = time() . '_' . $documentFile->getClientOriginalName();
                $filePath = $documentFile->storeAs('applications/documents', $docName, 'public');

                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_type' => $docType,
                    'file_path' => $filePath,
                ]);
            }
        }

        // Create application stages for this application
        foreach ($jobVacancy->selectionStages as $stage) {
            ApplicationStage::create([
                'application_id' => $application->id,
                'selection_stage_id' => $stage->id,
                'status' => $stage->sequence === 1 ? 'pending' : 'pending',
            ]);
        }

        // Send notification to applicant
        auth()->user()->notify(new ApplicationSubmitted($application));

        // Send notification to HRD users
        // notify specific HRD users
        $jobCreator = $jobVacancy->creator;
    if ($jobCreator) {
        $jobCreator->notify(new NewApplicationNotification($application));
    }
        return redirect()->route('applicant.applications')
            ->with('success', 'Your application has been submitted successfully!');
    }
}