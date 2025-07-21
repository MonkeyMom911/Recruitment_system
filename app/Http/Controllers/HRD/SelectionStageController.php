<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Models\SelectionStage;
use Illuminate\Http\Request;

class SelectionStageController extends Controller
{
    public function index(JobVacancy $jobVacancy)
    {
        $selectionStages = $jobVacancy->selectionStages()->orderBy('sequence')->get();
        
        return view('hrd.selection-stages.index', compact('jobVacancy', 'selectionStages'));
    }

    public function create(JobVacancy $jobVacancy)
    {
        return view('hrd.selection-stages.create', compact('jobVacancy'));
    }

    public function store(Request $request, JobVacancy $jobVacancy)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sequence' => 'required|integer|min:1',
        ]);
        
        // Adjust sequences if needed
        if ($jobVacancy->selectionStages()->where('sequence', '>=', $request->sequence)->exists()) {
            $jobVacancy->selectionStages()
                ->where('sequence', '>=', $request->sequence)
                ->increment('sequence');
        }
        
        $jobVacancy->selectionStages()->create($request->all());
        
        return redirect()->route('hrd.job-vacancies.selection-stages.index', $jobVacancy)
            ->with('success', 'Selection stage created successfully.');
    }

    public function edit(SelectionStage $selectionStage)
    {
        $jobVacancy = $selectionStage->jobVacancy;
        
        return view('hrd.selection-stages.edit', compact('selectionStage', 'jobVacancy'));
    }

    public function update(Request $request, SelectionStage $selectionStage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sequence' => 'required|integer|min:1',
        ]);
        
        $jobVacancy = $selectionStage->jobVacancy;
        $oldSequence = $selectionStage->sequence;
        $newSequence = $request->sequence;
        
        // Adjust sequences if needed
        if ($oldSequence !== $newSequence) {
            if ($oldSequence < $newSequence) {
                // Moving down
                $jobVacancy->selectionStages()
                    ->where('sequence', '>', $oldSequence)
                    ->where('sequence', '<=', $newSequence)
                    ->where('id', '!=', $selectionStage->id)
                    ->decrement('sequence');
            } else {
                // Moving up
                $jobVacancy->selectionStages()
                    ->where('sequence', '<', $oldSequence)
                    ->where('sequence', '>=', $newSequence)
                    ->where('id', '!=', $selectionStage->id)
                    ->increment('sequence');
            }
        }
        
        $selectionStage->update($request->all());
        
        return redirect()->route('hrd.job-vacancies.selection-stages.index', $jobVacancy)
            ->with('success', 'Selection stage updated successfully.');
    }

    public function destroy(SelectionStage $selectionStage)
    {
        $jobVacancy = $selectionStage->jobVacancy;
        $sequence = $selectionStage->sequence;
        
        // Check if the stage has application stages
        if ($selectionStage->applicationStages()->exists()) {
            return back()->with('error', 'Cannot delete selection stage with existing applications.');
        }
        
        $selectionStage->delete();
        
        // Adjust sequences
        $jobVacancy->selectionStages()
            ->where('sequence', '>', $sequence)
            ->decrement('sequence');
        
        return redirect()->route('hrd.job-vacancies.selection-stages.index', $jobVacancy)
            ->with('success', 'Selection stage deleted successfully.');
    }
}
