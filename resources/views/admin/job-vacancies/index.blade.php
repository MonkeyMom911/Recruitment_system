    @extends('layouts.admin')

    @section('header')
        {{ __('Manage Job Vacancies') }}
    @endsection

    @section('content')
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">All Job Vacancies</h2>
                <p class="text-sm text-gray-600 mt-1">Create and manage job postings</p>
            </div>
            <a href="{{ route('admin.job-vacancies.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create New Job
            </a>
        </div>

        <!-- Filter and Search -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="p-6">
                <form action="{{ route('admin.job-vacancies.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:gap-4">
                    <div class="w-full md:w-1/4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <select id="department" name="department" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-2/4">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search job title..." class="block w-full rounded-lg pr-10 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if(request()->hasAny(['status', 'department', 'search']))
                        <div class="w-full flex justify-end items-end">
                            <a href="{{ route('admin.job-vacancies.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

        <!-- Job Vacancies -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($jobVacancies as $jobVacancy)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $jobVacancy->title }}</h3>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($jobVacancy->status == 'active') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($jobVacancy->status) }}
                            </span>
                        </div>
                        
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ $jobVacancy->department }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $jobVacancy->location }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ ucfirst($jobVacancy->employment_type) }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Deadline: {{ $jobVacancy->end_date->format('M d, Y') }}
                            </div>
                        </div>
                        
                        <div class="mt-4 flex items-center">
                            <div class="bg-blue-50 text-blue-700 text-sm px-2 py-1 rounded flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ $jobVacancy->applications_count ?? 0 }} Applications
                            </div>
                            <div class="ml-auto text-sm text-gray-500">
                                Posted on {{ $jobVacancy->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        
                        <div class="mt-5 pt-4 border-t flex justify-between">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.job-vacancies.show', $jobVacancy) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 text-xs font-medium">View</a>
                                <a href="{{ route('admin.job-vacancies.edit', $jobVacancy) }}" class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded hover:bg-gray-100 text-xs font-medium">Edit</a>
                            </div>
                            
                            <div class="flex space-x-2">
                                
                                
                                <form action="{{ route('admin.job-vacancies.destroy', $jobVacancy) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job vacancy? This will also delete all associated applications.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 text-xs font-medium">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-xl shadow-sm p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No job vacancies found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        No job vacancies match your current filter criteria.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.job-vacancies.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create New Job
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            {{ $jobVacancies->withQueryString()->links() }}
        </div>
        
        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Jobs Summary Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Total Jobs</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $jobVacancies->total() }}</div>
                    </div>
                </div>
                <div class="mt-4 flex justify-between text-sm">
                    <div>
                        <span class="text-green-600 font-medium">{{ $activeVacancies }}</span>
                        <span class="text-gray-500"> Active</span>
                    </div>
                    <div>
                        <span class="text-red-600 font-medium">{{ $jobVacancies->total() - $activeVacancies }}</span>
                        <span class="text-gray-500"> Closed</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.job-vacancies.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create New Job
                    </a>
                    <a href="{{ route('admin.applications.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        View All Applications
                    </a>
                    <a href="{{ route('admin.reports.job-vacancies') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Generate Reports
                    </a>
                </div>
            </div>
            
            <!-- Popular Departments -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Top Departments</h3>
                
                @php
                    $departmentCounts = [];
                    foreach($jobVacancies as $job) {
                        if(!isset($departmentCounts[$job->department])) {
                            $departmentCounts[$job->department] = 0;
                        }
                        $departmentCounts[$job->department]++;
                    }
                    arsort($departmentCounts);
                    $topDepartments = array_slice($departmentCounts, 0, 3);
                @endphp
                
                <div class="space-y-4">
                    @forelse($topDepartments as $dept => $count)
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <div class="text-sm text-gray-500 flex-1">{{ $dept }}</div>
                            <div class="text-sm font-medium text-gray-800">{{ $count }} jobs</div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No departments data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endsection