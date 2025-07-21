<!-- resources/views/admin/users/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Users
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- User Basic Information Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-24 h-24 mb-4">
                                @if($user->profile_picture)
                                    <img class="w-24 h-24 rounded-full object-cover" src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-bold text-xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            <span class="px-3 py-1 mt-2 inline-flex text-sm leading-5 font-semibold rounded-full
                                @if($user->role == 'admin') bg-red-100 text-red-800
                                @elseif($user->role == 'hrd') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Contact Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500">Email</span>
                                    <p class="text-sm font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Phone Number</span>
                                    <p class="text-sm font-medium">{{ $user->phone_number ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Account Status</span>
                                    <p class="text-sm font-medium">
                                        @if($user->email_verified_at)
                                            <span class="text-green-600">Verified</span>
                                        @else
                                            <span class="text-yellow-600">Not Verified</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Joined</span>
                                    <p class="text-sm font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Information Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>

                        @if($user->profile)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Personal Details</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-xs text-gray-500">Date of Birth</span>
                                        <p class="text-sm font-medium">{{ $user->profile->date_of_birth ? $user->profile->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Gender</span>
                                        <p class="text-sm font-medium">{{ $user->profile->gender ? ucfirst($user->profile->gender) : 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Location</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-xs text-gray-500">Address</span>
                                        <p class="text-sm font-medium">{{ $user->profile->address ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">City</span>
                                        <p class="text-sm font-medium">{{ $user->profile->city ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Province</span>
                                        <p class="text-sm font-medium">{{ $user->profile->province ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Postal Code</span>
                                        <p class="text-sm font-medium">{{ $user->profile->postal_code ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($user->profile->bio)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Biography</h4>
                            <div class="bg-gray-50 p-4 rounded-md text-sm">
                                {{ $user->profile->bio }}
                            </div>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-4 text-gray-500">
                            <p>No profile information available for this user.</p>
                        </div>
                        @endif

                        <div class="mt-6 border-t pt-4">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Account Actions</h4>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Edit User
                                </a>
                                
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        {{ $user->email_verified_at ? 'Deactivate' : 'Activate' }} Account
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Delete User
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Activity Card -->
                @if($user->role == 'applicant')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-3">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Applications</h3>
                        
                        @if($user->applications && $user->applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->applications as $application)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->jobVacancy->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->jobVacancy->department }}</div>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4 text-gray-500">
                            <p>No applications found for this user.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @elseif($user->role == 'hrd')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-3">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Vacancies Created</h3>
                        
                        @if($user->jobVacancies && $user->jobVacancies->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->jobVacancies as $vacancy)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $vacancy->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vacancy->department }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($vacancy->status == 'active') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($vacancy->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vacancy->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.job-vacancies.show', $vacancy) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4 text-gray-500">
                            <p>No job vacancies have been created by this HRD.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>