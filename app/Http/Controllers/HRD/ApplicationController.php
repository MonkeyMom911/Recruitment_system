<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationStage;
use App\Notifications\ApplicationStatusUpdated;
use App\Notifications\InterviewScheduled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        // [1] Dapatkan ID dari HRD yang sedang login
        $hrdId = auth()->id();

        // [2] Dapatkan semua ID lowongan pekerjaan yang dibuat oleh HRD ini
        $hrdJobVacancyIds = \App\Models\JobVacancy::where('created_by', $hrdId)->pluck('id');

        // [3] Mulai query hanya untuk aplikasi yang terkait dengan lowongan di atas
        $query = Application::with(['user', 'jobVacancy'])
                            ->whereIn('job_vacancy_id', $hrdJobVacancyIds);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by job vacancy (hanya dari lowongan milik HRD ini)
        if ($request->filled('job_vacancy')) {
            $query->where('job_vacancy_id', $request->job_vacancy);
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
        
        // Ambil daftar lowongan untuk filter dropdown (hanya milik HRD ini)
        $jobVacancies = \App\Models\JobVacancy::whereIn('id', $hrdJobVacancyIds)
                                            ->pluck('title', 'id');
        
        return view('hrd.applications.index', compact('applications', 'jobVacancies'));
    }

    public function show(Application $application)
    {
        $application->load(['user.profile', 'jobVacancy', 'documents', 'stages.selectionStage']);
        
        return view('hrd.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:applied,screening,interview,test,hired,rejected',
            'notes' => 'nullable|string',
        ]);
        
        $oldStatus = $application->status;
        $application->status = $request->status;
        
        if ($request->filled('notes')) {
            $application->notes = $request->notes;
        }
        
        $application->save();
        
        // Notify the applicant
        $application->user->notify(new ApplicationStatusUpdated($application, $oldStatus));
        
        return back()->with('success', 'Application status updated successfully.');
    }

 public function updateStage(Request $request, ApplicationStage $applicationStage)
    {
        $request->validate([
            'status' => 'required|string|in:pending,passed,failed',
            'score' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $applicationStage) {
            // Update tahap saat ini dengan data dari request
            $applicationStage->update([
                'status' => $request->status,
                'score' => $request->score,
                'notes' => $request->notes,
                'completed_date' => in_array($request->status, ['passed', 'failed']) ? now() : null,
            ]);

            $application = $applicationStage->application;
            $oldStatus = $application->status;

            // Logika jika tahap LULUS
            if ($request->status === 'passed') {
                $allStages = $application->stages()->with('selectionStage')->get()->sortBy('selectionStage.sequence')->values();
                $currentIndex = $allStages->search(fn($item) => $item->id === $applicationStage->id);
                
                // Cek apakah ada tahap selanjutnya
                if (isset($allStages[$currentIndex + 1])) {
                    $nextStage = $allStages[$currentIndex + 1];
                    
                    // --- PERBAIKAN LOGIKA DIMULAI DI SINI ---
                    // Tentukan status baru berdasarkan nama tahap selanjutnya
                    $nextStageName = Str::lower($nextStage->selectionStage->name);
                    $newStatus = 'screening'; // Default status jika tidak cocok

                    if (Str::contains($nextStageName, 'interview')) {
                        $newStatus = 'interview';
                    } elseif (Str::contains($nextStageName, 'test')) {
                        $newStatus = 'test';
                    }
                    
                    // Update status utama aplikasi dengan status yang valid
                    $application->update(['status' => $newStatus]);
                    // --- AKHIR PERBAIKAN LOGIKA ---

                    // Aktifkan tahap selanjutnya
                    $nextStage->update(['status' => 'pending']);

                } else {
                    // Jika tidak ada tahap selanjutnya, pelamar diterima (hired)
                    $application->update(['status' => 'hired']);
                }
            } 
            // Logika jika tahap GAGAL
            elseif ($request->status === 'failed') {
                $application->update(['status' => 'rejected']);
            }

            // Kirim notifikasi jika status berubah
            if ($oldStatus !== $application->fresh()->status) {
                $application->user->notify(new ApplicationStatusUpdated($application, $oldStatus));
            }
        });

        return back()->with('success', 'Hasil tahapan seleksi berhasil diperbarui.');
    }
    public function scheduleStage(Request $request, ApplicationStage $applicationStage)
    {
        $request->validate([
            'scheduled_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);
        
        $applicationStage->scheduled_date = $request->scheduled_date;
        
        if ($request->filled('notes')) {
            $applicationStage->notes = $request->notes;
        }
        
        $applicationStage->save();
        
        // Notify the applicant
        $applicationStage->application->user->notify(new InterviewScheduled($applicationStage));
        
        return back()->with('success', 'Interview scheduled successfully.');
    }

    public function addNote(Request $request, Application $application)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);
        
        $application->notes = $application->notes 
            ? $application->notes . "\n\n" . now()->format('Y-m-d H:i') . " - " . $request->notes
            : now()->format('Y-m-d H:i') . " - " . $request->notes;
            
        $application->save();
        
        return back()->with('success', 'Note added successfully.');
    }
}
