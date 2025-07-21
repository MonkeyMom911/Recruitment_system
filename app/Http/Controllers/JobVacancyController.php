<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::active()->with('creator');

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('department', 'like', '%' . $search . '%');
            });
        }

        $jobVacancies = $query->latest()->paginate(10);
        
        return view('jobs.index', compact('jobVacancies'));
    }

    public function show(JobVacancy $jobVacancy)
    {
        if (!$jobVacancy->isActive()) {
            abort_if(!auth()->check() || !auth()->user()->isHRD() && !auth()->user()->isAdmin(), 404);
        }

        return view('jobs.show', compact('jobVacancy'));
    }
}

