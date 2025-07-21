<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobVacancyRequest; // <-- Pakai Form Request
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\NewJobVacancyPosted;
use Illuminate\Support\Facades\Notification;

class JobVacancyController extends Controller
{
    public function index()
    {
        $jobVacancies = JobVacancy::where('created_by', auth()->id())
            ->withCount('applications')
            ->latest()
            ->paginate(9);
            
        return view('hrd.job-vacancies.index', compact('jobVacancies'));
    }

    public function create()
    {
        return view('hrd.job-vacancies.create');
    }

    public function store(Request $request)
    {
        // [1] Pindahkan semua aturan validasi langsung ke sini
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship',
            'salary_range' => 'nullable|string|max:255',
            'quota' => 'required|integer|min:1',
            'status' => 'required|string|in:active,closed',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'stages' => 'required|array|min:1',
            'stages.*.name' => 'required|string|max:255',
            'stages.*.description' => 'nullable|string|max:255',
        ]);

        // [2] Gunakan transaksi database untuk keamanan data
        $jobVacancy = DB::transaction(function () use ($validatedData) {
            
            // Buat lowongan pekerjaan utama
            $jobVacancy = JobVacancy::create([
                'title' => $validatedData['title'],
                'department' => $validatedData['department'],
                'location' => $validatedData['location'],
                'employment_type' => $validatedData['employment_type'],
                'salary_range' => $validatedData['salary_range'],
                'quota' => $validatedData['quota'],
                'status' => $validatedData['status'],
                'description' => $validatedData['description'],
                'requirements' => $validatedData['requirements'],
                'responsibilities' => $validatedData['responsibilities'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'slug' => Str::slug($validatedData['title']) . '-' . Str::random(5),
                'created_by' => auth()->id(),
            ]);

            // Simpan tahap-tahap seleksi
            if (!empty($validatedData['stages'])) {
                foreach ($validatedData['stages'] as $index => $stageData) {
                    if (!empty($stageData['name'])) {
                        $jobVacancy->selectionStages()->create([
                            'name' => $stageData['name'],
                            'description' => $stageData['description'],
                            'sequence' => $index + 1,
                        ]);
                    }
                }
            }
            
            return $jobVacancy;
        });

         $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewJobVacancyPosted($jobVacancy->load('creator')));
        }

        return redirect()->route('hrd.job-vacancies.index', $jobVacancy)
            ->with('success', 'Job vacancy has been created successfully!');
    }

    public function show(JobVacancy $jobVacancy)
    {
        // Otorisasi sederhana: pastikan HRD hanya bisa melihat lowongan yang dia buat
        if ($jobVacancy->created_by !== auth()->id()) {
            abort(403);
        }
        
        $applications = $jobVacancy->applications()->with('user')->paginate(10);
        return view('hrd.job-vacancies.show', compact('jobVacancy', 'applications'));
    }

    public function edit(JobVacancy $jobVacancy)
    {
        if ($jobVacancy->created_by !== auth()->id()) {
            abort(403);
        }
        return view('hrd.job-vacancies.edit', compact('jobVacancy'));
    }

    public function update(Request $request, JobVacancy $jobVacancy)
    {
        if ($jobVacancy->created_by !== auth()->id()) {
            abort(403);
        }
        // Anda bisa membuat UpdateJobVacancyRequest sendiri untuk validasi update
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship',
            'salary_range' => 'nullable|string|max:255',
            'quota' => 'required|integer|min:1',
            'status' => 'required|string|in:active,closed',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $jobVacancy->update($validatedData);
        
        return redirect()->route('hrd.job-vacancies.index', $jobVacancy)
            ->with('success', 'Job vacancy updated successfully.');
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        if ($jobVacancy->created_by !== auth()->id()) {
            abort(403);
        }

        if ($jobVacancy->applications()->exists()) {
            return back()->with('error', 'Cannot delete a job vacancy that has applications.');
        }
        
        $jobVacancy->delete();
        
        return redirect()->route('hrd.job-vacancies.index')
            ->with('success', 'Job vacancy deleted successfully.');
    }
}