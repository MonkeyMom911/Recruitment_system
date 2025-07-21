<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Open Positions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Search and Filter Section -->
                    <div class="mb-8">
                        <form action="{{ route('jobs.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <div class="mt-1">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search job title, description..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="w-full md:w-1/5">
                                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                <select id="department" name="department" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">All Departments</option>
                                    <option value="Engineering" {{ request('department') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                                    <option value="Design" {{ request('department') == 'Design' ? 'selected' : '' }}>Design</option>
                                    <option value="Marketing" {{ request('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Finance" {{ request('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="HR" {{ request('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                    <option value="Sales" {{ request('department') == 'Sales' ? 'selected' : '' }}>Sales</option>
                                    <option value="Customer Support" {{ request('department') == 'Customer Support' ? 'selected' : '' }}>Customer Support</option>
                                </select>
                            </div>

                            <div class="w-full md:w-1/5">
                                <label for="employment_type" class="block text-sm font-medium text-gray-700">Job Type</label>
                                <select id="employment_type" name="employment_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">All Types</option>
                                    <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>

                            <div class="w-full md:w-1/5">
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" id="location" value="{{ request('location') }}" placeholder="City or region" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="w-full md:w-auto">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                @if(request('search') || request('department') || request('employment_type') || request('location'))
                                    <a href="{{ route('jobs.index') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Job Listings -->
                    <div class="space-y-6">
                        @forelse($jobVacancies as $jobVacancy)
                            <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                                <div class="px-6 py-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900 hover:text-blue-600">
                                                <a href="{{ route('jobs.show', $jobVacancy->slug) }}">{{ $jobVacancy->title }}</a>
                                            </h3>
                                            <div class="mt-1 flex flex-wrap items-center text-sm text-gray-600 space-x-4">
                                                <div class="flex items-center mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $jobVacancy->department }}
                                                </div>
                                                <div class="flex items-center mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $jobVacancy->location }}
                                                </div>
                                                <div class="flex items-center mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ ucfirst($jobVacancy->employment_type) }}
                                                </div>
                                                @if($jobVacancy->salary_range)
                                                    <div class="flex items-center mt-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        {{ $jobVacancy->salary_range }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $jobVacancy->quota }} open position{{ $jobVacancy->quota > 1 ? 's' : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">
                                            {{ Str::limit(strip_tags($jobVacancy->description), 250) }}
                                        </p>
                                    </div>
                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="text-xs text-gray-500">
                                            Posted on {{ $jobVacancy->created_at->format('M d, Y') }} | 
                                            Apply before {{ $jobVacancy->end_date->format('M d, Y') }}
                                        </div>
                                        <a href="{{ route('jobs.show', $jobVacancy->slug) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No job vacancies found</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    We couldn't find any job vacancies matching your criteria.
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Clear filters
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $jobVacancies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>