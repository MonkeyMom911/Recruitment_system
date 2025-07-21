<!-- resources/views/admin/applications/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Application Details') }}
            </h2>
            <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Applications
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Application Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Application ID: #{{ $application->id }}</h3>
                            <div class="mt-2 flex items-center">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($application->status == 'applied') bg-gray-100 text-gray-800
                                    @elseif($application->status == 'screening') bg-blue-100 text-blue-800
                                    @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                    @elseif($application->status == 'test') bg-yellow-100 text-yellow-800
                                    @elseif($application->status == 'hired') bg-green-100 text-green-800
                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                                <span class="ml-2 text-sm text-gray-500">
                                    Applied: {{ $application->created_at->format('M d, Y H:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this application? This action cannot be undone.')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Applicant Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h3>
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if($application->user->profile_picture)
                                    <img class="h-16 w-16 rounded-full" src="{{ Storage::url($application->user->profile_picture) }}" alt="{{ $application->user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium text-xl">
                                            {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $application->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                                @if($application->user->phone_number)
                                    <p class="text-sm text-gray-600">{{ $application->user->phone_number }}</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($application->user->profile)
                            <div class="mt-4 space-y-2">
                                @if($application->user->profile->address)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Address</h4>
                                        <p class="text-sm text-gray-900">
                                            {{ $application->user->profile->address }}, 
                                            {{ $application->user->profile->city }}, 
                                            {{ $application->user->profile->province }} 
                                            {{ $application->user->profile->postal_code }}
                                        </p>
                                    </div>
                                @endif
                                
                                @if($application->user->profile->date_of_birth)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Date of Birth</h4>
                                        <p class="text-sm text-gray-900">{{ $application->user->profile->date_of_birth->format('M d, Y') }}</p>
                                    </div>
                                @endif
                                
                                @if($application->user->profile->gender)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Gender</h4>
                                        <p class="text-sm text-gray-900">{{ ucfirst($application->user->profile->gender) }}</p>
                                    </div>
                                @endif
                                
                                @if($application->user->profile->bio)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Bio</h4>
                                        <p class="text-sm text-gray-900">{{ $application->user->profile->bio }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <a href="mailto:{{ $application->user->email }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email Applicant
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Information</h3>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Position</h4>
                                <p class="text-sm font-semibold text-gray-900">{{ $application->jobVacancy->title }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Department</h4>
                                <p class="text-sm text-gray-900">{{ $application->jobVacancy->department }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Location</h4>
                                <p class="text-sm text-gray-900">{{ $application->jobVacancy->location }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Employment Type</h4>
                                <p class="text-sm text-gray-900">{{ ucfirst($application->jobVacancy->employment_type) }}</p>
                            </div>
                            
                            @if($application->jobVacancy->salary_range)
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500 uppercase">Salary Range</h4>
                                    <p class="text-sm text-gray-900">{{ $application->jobVacancy->salary_range }}</p>
                                </div>
                            @endif
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Expected Salary</h4>
                                <p class="text-sm text-gray-900">Rp {{ number_format($application->expected_salary, 0, ',', '.') }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Posted By</h4>
                                <p class="text-sm text-gray-900">{{ $application->jobVacancy->creator->name }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Status</h4>
                                <p class="text-sm text-gray-900">{{ ucfirst($application->jobVacancy->status) }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('admin.job-vacancies.show', $application->jobVacancy) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Job Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Selection Process -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Selection Progress</h3>
                        
                        <div class="relative">
                            @foreach($application->stages as $index => $stage)
                                <div class="relative flex items-start group @if(!$loop->last) pb-10 @endif">
                                    <div class="flex items-center h-9 @if(!$loop->last) after:content-[''] after:absolute after:left-4 after:top-9 after:bottom-0 after:w-0.5 after:bg-gray-200 @endif">
                                        <span class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full 
                                            @if($stage->status == 'passed') bg-green-500 
                                            @elseif($stage->status == 'failed') bg-red-500 
                                            @elseif($stage->status == 'in_progress') bg-yellow-500 
                                            @else bg-gray-300 
                                            @endif">
                                            @if($stage->status == 'passed')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @elseif($stage->status == 'failed')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            @else
                                                <span class="text-sm text-white font-bold">{{ $index + 1 }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $stage->selectionStage->name }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $stage->selectionStage->description }}</p>
                                        
                                        @if($stage->status == 'pending' && $stage->scheduled_date)
                                            <div class="mt-2 bg-blue-50 p-2 rounded-md">
                                                <p class="text-xs text-blue-800">
                                                    <span class="font-semibold">Scheduled: </span>
                                                    {{ $stage->scheduled_date->format('l, F j, Y \a\t g:i A') }}
                                                </p>
                                                @if($stage->notes)
                                                    <p class="text-xs text-blue-600 mt-1">{{ $stage->notes }}</p>
                                                @endif
                                            </div>
                                        @elseif($stage->status == 'passed')
                                            <div class="mt-2 bg-green-50 p-2 rounded-md">
                                                <p class="text-xs text-green-800">
                                                    <span class="font-semibold">Completed: </span>
                                                    {{ $stage->completed_date ? $stage->completed_date->format('M d, Y') : 'N/A' }}
                                                </p>
                                                @if($stage->score)
                                                    <p class="text-xs text-green-800">
                                                        <span class="font-semibold">Score: </span>
                                                        {{ $stage->score }}/100
                                                    </p>
                                                @endif
                                                @if($stage->notes)
                                                    <p class="text-xs text-green-600 mt-1">{{ $stage->notes }}</p>
                                                @endif
                                            </div>
                                        @elseif($stage->status == 'failed')
                                            <div class="mt-2 bg-red-50 p-2 rounded-md">
                                                <p class="text-xs text-red-800">
                                                    <span class="font-semibold">Result: </span>
                                                    Not selected to move forward
                                                </p>
                                                @if($stage->score)
                                                    <p class="text-xs text-red-800">
                                                        <span class="font-semibold">Score: </span>
                                                        {{ $stage->score }}/100
                                                    </p>
                                                @endif
                                                @if($stage->notes)
                                                    <p class="text-xs text-red-600 mt-1">{{ $stage->notes }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Documents -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cover Letter -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Cover Letter</h3>
                        <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-800 whitespace-pre-wrap">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                </div>

                <!-- CV and Additional Documents -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Application Documents</h3>
                        
                        <ul class="divide-y divide-gray-200">
                            @if ($application->cv_path)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center min-w-0">
                                    {{-- [1] Ikon SVG ditambahkan kembali di sini --}}
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">CV / Resume</p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($application->cv_path) }}</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 text-sm">
                                        View
                                    </a>
                                </div>
                            </li>
                            @endif
                            
                            @foreach($application->documents as $document)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center min-w-0">
                                    {{-- [2] Ikon SVG juga ditambahkan untuk setiap dokumen tambahan --}}
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ ucfirst($document->document_type) }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($document->file_path) }}</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 text-sm">
                                        View
                                    </a>
                                </div>
                            </li>
                            @endforeach
                            
                            {{-- Kondisi jika tidak ada dokumen sama sekali --}}
                            @if($application->documents->isEmpty() && !$application->cv_path)
                            <li class="py-3 text-sm text-gray-500 text-center">
                                No documents provided.
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Application Notes</h3>
                    
                    @if($application->notes)
                        <div class="bg-gray-50 p-4 rounded-md mb-4">
                            <div class="text-sm text-gray-800 whitespace-pre-wrap">
                                {{ $application->notes }}
                            </div>
                        </div>
                    @else
                        <div class="text-sm text-gray-500 mb-4">
                            No notes have been added for this application.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>