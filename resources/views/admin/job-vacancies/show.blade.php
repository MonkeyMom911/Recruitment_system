<!-- resources/views/admin/job-vacancies/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Vacancy Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.job-vacancies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Job Vacancies
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Job Vacancy Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $jobVacancy->title }}</h3>
                            <div class="mt-2 flex flex-wrap items-center gap-4">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($jobVacancy->status == 'active') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($jobVacancy->status) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $jobVacancy->department }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $jobVacancy->location }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ ucfirst($jobVacancy->employment_type) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $jobVacancy->salary_range ?? 'Negotiable' }}
                                </span>
                            </div>
                            <div class="mt-2 text-sm text-gray-500">
                                Posted: {{ $jobVacancy->created_at->format('M d, Y') }} | 
                                Start Date: {{ $jobVacancy->start_date->format('M d, Y') }} | 
                                End Date: {{ $jobVacancy->end_date->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                            <form action="{{ route('admin.job-vacancies.destroy', $jobVacancy) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job vacancy? This will also delete all associated applications.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Vacancy
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column - Basic Information -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Job Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Quota</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $jobVacancy->quota }} position(s)</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Employment Type</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($jobVacancy->employment_type) }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Department</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $jobVacancy->department }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Location</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $jobVacancy->location }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Salary Range</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $jobVacancy->salary_range ?? 'Negotiable' }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Created By</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $jobVacancy->creator->name }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase">Job URL</h4>
                                    <p class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('jobs.show', $jobVacancy->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                            {{ route('jobs.show', $jobVacancy->slug) }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Job Details -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white">
                            <div x-data="{ tab: 'description' }">
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8">
                                        <a @click.prevent="tab = 'description'" :class="{ 'border-blue-500 text-blue-600': tab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'description' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer">
                                            Description
                                        </a>
                                        <a @click.prevent="tab = 'requirements'" :class="{ 'border-blue-500 text-blue-600': tab === 'requirements', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'requirements' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer">
                                            Requirements
                                        </a>
                                        <a @click.prevent="tab = 'responsibilities'" :class="{ 'border-blue-500 text-blue-600': tab === 'responsibilities', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'responsibilities' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer">
                                            Responsibilities
                                        </a>
                                    </nav>
                                </div>

                                <!-- Description Tab -->
                                <div x-show="tab === 'description'" class="mt-6 prose prose-blue max-w-none">
                                    <div class="whitespace-pre-line">{{ $jobVacancy->description }}</div>
                                </div>

                                <!-- Requirements Tab -->
                                <div x-show="tab === 'requirements'" class="mt-6 prose prose-blue max-w-none">
                                    <div class="whitespace-pre-line">{{ $jobVacancy->requirements }}</div>
                                </div>

                                <!-- Responsibilities Tab -->
                                <div x-show="tab === 'responsibilities'" class="mt-6 prose prose-blue max-w-none">
                                    <div class="whitespace-pre-line">{{ $jobVacancy->responsibilities }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selection Stages -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Selection Stages</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sequence</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stage Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jobVacancy->selectionStages as $stage)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $stage->sequence }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $stage->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $stage->description }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No selection stages defined.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Applications -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Applications ({{ $applications->total() }})</h3>
                    </div>

                    @if ($applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Salary</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($application->user->profile_picture)
                                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($application->user->profile_picture) }}" alt="{{ $application->user->name }}">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                                <span class="text-white font-medium text-sm">
                                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $application->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $application->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($application->status == 'applied') bg-gray-100 text-gray-800
                                                    @elseif($application->status == 'screening') bg-blue-100 text-blue-800
                                                    @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                                    @elseif($application->status == 'test') bg-yellow-100 text-yellow-800
                                                    @elseif($application->status == 'hired') bg-green-100 text-green-800
                                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $application->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Rp {{ number_format($application->expected_salary, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                There are no applications for this job vacancy yet.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>