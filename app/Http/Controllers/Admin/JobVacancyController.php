<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Support\Str;
use carbon\Carbon;
use App\Http\Requests\StoreJobVacancyRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\NewJobVacancyPosted;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::with('creator')->withCount('applications');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        // Search by title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('department', 'like', '%' . $search . '%');
            });
        }
        
        $jobVacancies = $query->latest()->paginate(15);
        $departments = JobVacancy::select('department')->distinct()->pluck('department');
        
        $activeVacancies = JobVacancy::where('status', 'active')
        ->whereDate('end_date', '>=', Carbon::today())
        ->count();
        return view('admin.job-vacancies.index', compact('jobVacancies', 'departments', 'activeVacancies'));
    }

    public function create()
    {
        
        return view('admin.job-vacancies.create');
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

        return redirect()->route('admin.job-vacancies.show', $jobVacancy)
            ->with('success', 'Job vacancy created successfully by Admin.');
    }

    public function update(Request $request, JobVacancy $jobVacancy)
    {
        $validated = $request->validate([
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

        $jobVacancy->update($validated);

        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy updated successfully.');
}   

    public function show(JobVacancy $jobVacancy)
    {
        $jobVacancy->load(['creator', 'selectionStages' => function($query) {
            $query->orderBy('sequence');
        }]);
        
        $applications = $jobVacancy->applications()
            ->with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.job-vacancies.show', compact('jobVacancy', 'applications'));
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        // Check if the job vacancy has applications
        if ($jobVacancy->applications()->exists()) {
            return back()->with('error', 'Cannot delete job vacancy with existing applications.');
        }
        
        $jobVacancy->delete();
        
        
        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy deleted successfully.');
    }

    public function edit(JobVacancy $jobVacancy)
    {
    $departments = JobVacancy::select('department')->distinct()->pluck('department');
    
    return view('admin.job-vacancies.edit', compact('jobVacancy', 'departments'));
    }


}