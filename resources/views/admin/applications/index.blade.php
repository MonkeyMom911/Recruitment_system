<!-- resources/views/admin/applications/index.blade.php -->
@extends('layouts.admin')

@section('header')
    {{ __('Manage Applications') }}
@endsection

@section('content')
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">All Applications</h2>
            <p class="text-sm text-gray-600 mt-1">Track and manage job applications</p>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-800">All Applications</h2>
            <p class="text-sm text-gray-600 mt-1">Track and manage job applications</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.reports.applications') }}" class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Generate Report
            </a>
            <a href="{{ route('admin.reports.export') }}?report_type=applications" class="flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Data
            </a>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('admin.applications.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:gap-4">
                <div class="w-full md:w-1/5">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                        <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Screening</option>
                        <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="test" {{ request('status') == 'test' ? 'selected' : '' }}>Test</option>
                        <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="w-full md:w-1/5">
                    <label for="job_vacancy_id" class="block text-sm font-medium text-gray-700 mb-1">Job Position</label>
                    <select id="job_vacancy_id" name="job_vacancy_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Positions</option>
                        @foreach($jobVacancies as $id => $title)
                            <option value="{{ $id }}" {{ request('job_vacancy_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/5">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="w-full md:w-1/5">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="w-full">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Applicant</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name or email..." class="block w-full rounded-lg pr-10 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['status', 'job_vacancy_id', 'start_date', 'end_date', 'search']))
                    <div class="w-full flex justify-end items-end mt-4">
                        <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
    
    <!-- Status Tabs -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="p-4">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px space-x-8">
                    <a href="{{ route('admin.applications.index') }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ !request('status') ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        All
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $applications }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'applied']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ request('status') == 'applied' ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Applied
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">{{ $statusCounts['applied'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'screening']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ request('status') == 'screening' ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Screening
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-600">{{ $statusCounts['screening'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'interview']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ request('status') == 'interview' ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Interview
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-purple-100 text-purple-600">{{ $statusCounts['interview'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'test']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ request('status') == 'test' ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Test
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-600">{{ $statusCounts['test'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'hired']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ request('status') == 'hired' ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Hired
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-600">{{ $statusCounts['hired'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.applications.index', ['status' => 'rejected']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 {{ request('status') == 'rejected' ? 'font-medium text-blue-600 border-blue-500' : 'font-medium text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                        Rejected
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-600">{{ $statusCounts['rejected'] ?? 0 }}</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if(count($applications) > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skills</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applications as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($application->user->profile_picture)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($application->user->profile_picture) }}" alt="{{ $application->user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                            {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $application->jobVacancy->title }}</div>
                            <div class="text-sm text-gray-500">{{ $application->jobVacancy->department }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($application->status == 'applied') bg-gray-100 text-gray-800
                                    @elseif($application->status == 'screening') bg-blue-100 text-blue-800
                                    @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                    @elseif($application->status == 'test') bg-yellow-100 text-yellow-800
                                    @elseif($application->status == 'hired') bg-green-100 text-green-800
                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                                <div class="ml-2">
                                    <!-- Dropdown Menu -->
                                    @if($application->status != 'hired' && $application->status != 'rejected')
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" 
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 max-h-60 overflow-y-auto" 
                                        style="display: none;">
                                        
                                        <form action="{{ route('admin.applications.update-status', $application) }}" method="POST" x-ref="updateForm" class="py-1">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <input type="hidden" name="status" x-ref="statusInput">

                                            <button type="button" @click="$refs.statusInput.value = 'screening'; $refs.updateForm.submit()" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Move to Screening
                                            </button>
                                            <button type="button" @click="$refs.statusInput.value = 'interview'; $refs.updateForm.submit()"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Move to Interview
                                            </button>
                                            <button type="button" @click="$refs.statusInput.value = 'test'; $refs.updateForm.submit()"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Move to Test
                                            </button>
                                            <button type="button" @click="$refs.statusInput.value = 'hired'; $refs.updateForm.submit()"
                                                    class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100">
                                                Hire Applicant
                                            </button>
                                            <button type="button" @click="$refs.statusInput.value = 'rejected'; $refs.updateForm.submit()"
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100">
                                                Reject Applicant
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div>
                            
                            @if ($application->stages->count() > 0)
                            <div class="mt-2 flex items-center">
                                <div class="text-xs text-gray-500">
                                    Current stage: 
                                    <span class="font-medium">
                                        @php
                                            $currentStageName = 'Initial Review'; // [1] Nilai default

                                            // [2] Jika statusnya final (hired/rejected), langsung tampilkan statusnya
                                            if (in_array($application->status, ['hired', 'rejected'])) {
                                                $currentStageName = ucfirst($application->status);
                                            } else {
                                                // [3] Cari nama tahap yang cocok dengan status aplikasi (case-insensitive)
                                                $activeStage = $application->stages
                                                    ->firstWhere(function ($stage) use ($application) {
                                                        return strcasecmp(optional($stage->selectionStage)->name, $application->status) === 0;
                                                    });

                                                if ($activeStage) {
                                                    $currentStageName = $activeStage->selectionStage->name;
                                                } elseif ($application->status != 'applied') {
                                                    // [4] Fallback jika tidak ada nama stage yang cocok, gunakan status utama
                                                    $currentStageName = ucfirst($application->status);
                                                }
                                            }
                                        @endphp
                                        {{ $currentStageName }}
                                    </span>
                                 </div>
                            </div>
                            @endif
                        </td>  
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(['PHP', 'Laravel', 'JavaScript', 'CSS', 'React'] as $skill)
                                @if(Str::contains(strtolower($application->cover_letter), strtolower($skill)))
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">{{ $skill }}</span>
                                @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                            
                            <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this application? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    No applications matching your criteria were found.
                </p>
                <div class="mt-6">
                    <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Clear Filters
                    </a>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $applications->withQueryString()->links() }}
        </div>
    </div>
    
    <!-- Stats and Insights -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Application Overview Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Application Overview</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $applicationsCount }}</div>
                        <div class="text-sm text-blue-600">Total Applications</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $statusCounts['hired'] ?? 0 }}</div>
                        <div class="text-sm text-green-600">Hired Applicants</div>
                    </div>
                </div>
                
                <div class="pt-4 border-t">
                    <div class="text-sm font-medium text-gray-700 mb-2">Status Distribution</div>
                    
                    <!-- Applied -->
                    <div class="mb-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Applied</span>
                            <span>{{ $statusCounts['applied'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-500 h-2 rounded-full" style="width: {{ $applications->total() > 0 ? round((($statusCounts['applied'] ?? 0) / $applications->total()) * 100, 2) : 0 }}%"
                            ></div>
                        </div>
                    </div>
                    
                    <!-- Screening -->
                    <div class="mb-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Screening</span>
                            <span>{{ $statusCounts['screening'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" 
                                style="width: {{ $applications->total() > 0 ? round((($statusCounts['screening'] ?? 0) / $applications->total()) * 100, 2) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Interview -->
                    <div class="mb-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Interview</span>
                            <span>{{ $statusCounts['interview'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" 
                                style="width: {{ $applications->total() > 0 ? round((($statusCounts['interview'] ?? 0) / $applications->total()) * 100, 2) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Test -->
                    <div class="mb-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Test</span>
                            <span>{{ $statusCounts['test'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" 
                                style="width: {{ $applications->total() > 0 ? round((($statusCounts['test'] ?? 0) / $applications->total()) * 100, 2) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Hired -->
                    <div class="mb-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Hired</span>
                            <span>{{ $statusCounts['hired'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" 
                                style="width: {{ $applications->total() > 0 ? round((($statusCounts['hired'] ?? 0) / $applications->total()) * 100, 2) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Rejected -->
                    <div class="mb-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Rejected</span>
                            <span>{{ $statusCounts['rejected'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" 
                                style="width: {{ $applications->total() > 0 ? round((($statusCounts['rejected'] ?? 0) / $applications->total()) * 100, 2) : 0 }}%">
                            </div>
                        </div>
                    </div>

        
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @forelse($applications->take(5) as $recentApp)
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full
                                    @if($recentApp->status == 'applied') bg-gray-100
                                    @elseif($recentApp->status == 'screening') bg-blue-100
                                    @elseif($recentApp->status == 'interview') bg-purple-100
                                    @elseif($recentApp->status == 'test') bg-yellow-100
                                    @elseif($recentApp->status == 'hired') bg-green-100
                                    @elseif($recentApp->status == 'rejected') bg-red-100
                                    @endif
                                    flex items-center justify-center text-sm">
                                    <span class="
                                        @if($recentApp->status == 'applied') text-gray-600
                                        @elseif($recentApp->status == 'screening') text-blue-600
                                        @elseif($recentApp->status == 'interview') text-purple-600
                                        @elseif($recentApp->status == 'test') text-yellow-600
                                        @elseif($recentApp->status == 'hired') text-green-600
                                        @elseif($recentApp->status == 'rejected') text-red-600
                                        @endif">
                                        {{ strtoupper(substr($recentApp->status, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $recentApp->user->name }} 
                                    <span class="font-normal text-gray-500">applied for</span> 
                                    {{ $recentApp->jobVacancy->title }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $recentApp->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">No recent applications</p>
                        @endforelse
                    </div>
            
            <div class="mt-4 pt-4 border-t">
                <h4 class="text-xs font-medium text-gray-700 mb-2">Upcoming Interviews</h4>
                
                @php
                    $upcomingInterviews = \App\Models\ApplicationStage::with(['application.user', 'application.jobVacancy', 'selectionStage'])
                        ->where('status', 'pending')
                        ->whereNotNull('scheduled_date')
                        ->where('scheduled_date', '>=', now())
                        ->where('scheduled_date', '<=', now()->addDays(7))
                        ->orderBy('scheduled_date')
                        ->take(3)
                        ->get();
                @endphp
                
                @forelse($upcomingInterviews as $interview)
                <div class="flex items-center p-2 border rounded-md mb-2 hover:bg-gray-50">
                    <div class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-md flex items-center justify-center text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-900">{{ $interview->scheduled_date->format('M d, g:i A') }}</p>
                        <p class="text-xs text-gray-500">{{ $interview->application->user->name }} - {{ $interview->selectionStage->name }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">No upcoming interviews</p>
                @endforelse
            </div>
        </div>
        
        <!-- Popular Job Positions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Top Job Positions</h3>
            
            @php
                $popularJobs = $applications->groupBy('job_vacancy_id')->map(function($group) {
                    return [
                        'count' => $group->count(),
                        'title' => $group->first()->jobVacancy->title,
                        'department' => $group->first()->jobVacancy->department
                    ];
                })->sortByDesc('count')->take(5);
            @endphp
            
            <div class="space-y-4">
                @forelse($popularJobs as $job)
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $job['title'] }}</div>
                        <div class="text-xs text-gray-500">{{ $job['department'] }}</div>
                    </div>
                    <div class="flex items-center">
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">{{ $job['count'] }} applications</span>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">No jobs data available</p>
                @endforelse
            </div>
            
            <div class="mt-6 pt-4 border-t">
                <a href="{{ route('admin.job-vacancies.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Manage Job Vacancies
                </a>
            </div>
        </div>
    </div>
@endsection