@extends('layouts.admin')

@section('header')
    {{ __('Manage Users') }}
@endsection

@section('content')
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">All Users</h2>
            <p class="text-sm text-gray-600 mt-1">Manage users, roles, and permissions</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New User
        </a>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="p-6 overflow-x-auto">
            <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:gap-4">
                <div class="w-full md:w-1/4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="role" name="role" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="hrd" {{ request('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                        <option value="applicant" {{ request('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                    </select>
                </div>

                <div class="w-full md:w-1/4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="w-full md:w-2/4">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="block w-full rounded-lg pr-10 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['role', 'status', 'search']))
                    <div class="w-full flex justify-end items-end">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

    <!-- Users Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse($users as $user)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <!-- User Header -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($user->profile_picture)
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white text-lg font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($user->role == 'admin') bg-red-100 text-red-800
                            @elseif($user->role == 'hrd') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    
                    <!-- User Info -->
                    <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="text-gray-500">Status:</span>
                            <span class="font-medium 
                                @if($user->email_verified_at) text-green-600
                                @else text-red-600
                                @endif">
                                {{ $user->email_verified_at ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500">Phone:</span>
                            <span class="font-medium">{{ $user->phone_number ?? 'N/A' }}</span>
                        </div>
                        @if($user->profile)
                        <div>
                            <span class="text-gray-500">Location:</span>
                            <span class="font-medium">{{ $user->profile->city ?? 'N/A' }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="text-gray-500">Joined:</span>
                            <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-5 flex justify-between border-t pt-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 text-xs font-medium">View</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded hover:bg-gray-100 text-xs font-medium">Edit</a>
                        </div>
                        
                        @if($user->id !== auth()->id())
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Are you sure you want to {{ $user->email_verified_at ? 'deactivate' : 'activate' }} this user?')" class="px-3 py-1.5 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 text-xs font-medium">
                                        {{ $user->email_verified_at ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 text-xs font-medium">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-xl shadow-sm p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    No users match your current filter criteria.
                </p>
                <div class="mt-6">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Clear Filters
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $users->withQueryString()->links() }}
    </div>
    
    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold text-gray-800">{{ $users->total() }}</div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-sm font-medium text-gray-500">Total Users</div>
        </div>
        
        <!-- User Roles Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">User Roles</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></div>
                    <div class="text-sm text-gray-500 flex-1">Admin</div>
                    <div class="text-sm font-medium text-gray-800">{{ $userRoles['admin'] ?? 0 }}</div>
                </div>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                    <div class="text-sm text-gray-500 flex-1">HRD</div>
                    <div class="text-sm font-medium text-gray-800">{{ $userRoles['hrd'] ?? 0 }}</div>
                </div>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <div class="text-sm text-gray-500 flex-1">Applicant</div>
                    <div class="text-sm font-medium text-gray-800">{{ $userRoles['applicant'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.users.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add New User
                </a>
                <a href="{{ route('admin.users.export', request()->only(['role', 'status', 'search'])) }}"  class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Export Users List
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    User Settings
                </a>
            </div>
        </div>
    </div>
@endsection