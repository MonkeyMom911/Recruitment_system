@extends('layouts.admin') {{-- Ganti sesuai layout kamu --}}

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6">Edit Job Vacancy</h2>

    <form action="{{ route('admin.job-vacancies.update', $jobVacancy->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $jobVacancy->title) }}" required>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="5" class="w-full border rounded px-3 py-2">{{ old('description', $jobVacancy->description) }}</textarea>
        </div>

        {{-- Requirements --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Requirements</label>
            <textarea name="requirements" rows="5" class="w-full border rounded px-3 py-2">{{ old('requirements', $jobVacancy->requirements) }}</textarea>
        </div>

        {{-- Responsibilities --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Responsibilities</label>
            <textarea name="responsibilities" rows="5" class="w-full border rounded px-3 py-2">{{ old('responsibilities', $jobVacancy->responsibilities) }}</textarea>
        </div>

        {{-- Location --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Location</label>
            <input type="text" name="location" class="w-full border rounded px-3 py-2" value="{{ old('location', $jobVacancy->location) }}">
        </div>

        {{-- Employment Type --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Employment Type</label>
            <select name="employment_type" class="w-full border rounded px-3 py-2">
                <option value="full-time" {{ old('employment_type', $jobVacancy->employment_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                <option value="part-time" {{ old('employment_type', $jobVacancy->employment_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                <option value="contract" {{ old('employment_type', $jobVacancy->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
            </select>
        </div>

        {{-- Department --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Department</label>
            <input type="text" name="department" class="w-full border rounded px-3 py-2" value="{{ old('department', $jobVacancy->department) }}">
        </div>

        {{-- Salary Range --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Salary Range</label>
            <input type="text" name="salary_range" class="w-full border rounded px-3 py-2" value="{{ old('salary_range', $jobVacancy->salary_range) }}">
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="active" {{ old('status', $jobVacancy->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="closed" {{ old('status', $jobVacancy->status) == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        {{-- Quota --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Quota</label>
            <input type="number" name="quota" class="w-full border rounded px-3 py-2" value="{{ old('quota', $jobVacancy->quota) }}">
        </div>

        {{-- Start Date --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Start Date</label>
            <input type="date" name="start_date" class="w-full border rounded px-3 py-2" value="{{ old('start_date', \Carbon\Carbon::parse($jobVacancy->start_date)->format('Y-m-d')) }}">
        </div>

        {{-- End Date --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">End Date</label>
            <input type="date" name="end_date" class="w-full border rounded px-3 py-2" value="{{ old('end_date', \Carbon\Carbon::parse($jobVacancy->end_date)->format('Y-m-d')) }}">
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Job Vacancy</button>
        </div>
    </form>
</div>
@endsection
