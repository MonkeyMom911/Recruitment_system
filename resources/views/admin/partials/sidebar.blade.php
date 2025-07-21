<!-- resources/views/admin/partials/sidebar.blade.php -->
<div class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-indigo-800 lg:translate-x-0 lg:static lg:inset-0"
     :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}">
    <div class="flex items-center justify-between p-4">
        <div class="text-xl font-bold text-white" x-show="sidebarOpen">
            {{ config('app.name', 'PT Winnicode') }}
        </div>
        <div class="w-10 h-10 rounded-full bg-indigo-700 flex items-center justify-center font-bold text-xl text-white" x-show="!sidebarOpen">
            W
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-md hover:bg-indigo-700 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
    </div>
    
    <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ !$sidebarOpen ? 'mx-auto' : 'mr-3' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ !$sidebarOpen ? 'mx-auto' : 'mr-3' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span x-show="sidebarOpen">Users</span>
        </a>
        
        <a href="{{ route('admin.job-vacancies.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.job-vacancies*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ !$sidebarOpen ? 'mx-auto' : 'mr-3' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span x-show="sidebarOpen">Job Vacancies</span>
        </a>
        
        <a href="{{ route('admin.applications.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.applications*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ !$sidebarOpen ? 'mx-auto' : 'mr-3' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span x-show="sidebarOpen">Applications</span>
        </a>
        
        <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.settings*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ !$sidebarOpen ? 'mx-auto' : 'mr-3' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span x-show="sidebarOpen">Settings</span>
        </a>
    </nav>
</div>