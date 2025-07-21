<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
       <aside x-bind:class="{
                                'translate-x-0': sidebarOpen || $screen('lg'),
                                '-translate-x-full': !sidebarOpen && !$screen('lg'),
                                'w-64': sidebarOpen,
                                'w-20': !sidebarOpen && $screen('lg')
                            }"
                x-data="{
                            sidebarOpen: $screen('lg'),
                            init() {
                                const checkScreen = () => {
                                    if (window.innerWidth >= 1024) {
                                        this.sidebarOpen = true;
                                    }
                                };
                                checkScreen();
                                window.addEventListener('resize', checkScreen);
                            }
                        }"
    x-init="init()"
            class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 max-h-screen overflow-hidden transform bg-white border-r shadow-lg lg:z-auto lg:static lg:shadow-none transition-all duration-300">
            <div class="flex items-center justify-between flex-shrink-0 p-4">
                <span class="flex items-center text-xl font-medium">
                    <template x-if="sidebarOpen">
                        <span>
                            <span class="text-blue-600">Recruit</span><span class="text-gray-900">Pro</span>
                        </span>
                    </template>
                    <template x-if="!sidebarOpen">
                        <span class="text-blue-600 text-2xl font-bold">R</span>
                    </template>
                </span>
                <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-lg lg:hidden hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            
            <nav class="flex-1 overflow-hidden hover:overflow-y-auto">
                <ul class="p-2 overflow-hidden">
                    @foreach (config('admin_nav') as $item)
                    <li>
                        <a href="{{ route($item['route']) }}" 
                            class="flex items-center p-2 space-x-2 rounded-md {{ request()->routeIs($item['active_on']) ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                            
                            {!! $item['icon'] !!} {{-- Tampilkan SVG icon --}}

                            <span x-show="sidebarOpen" x-transition.opacity class="truncate">{{ $item['title'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </nav>
            
            <div class="flex-shrink-0 p-2 border-t">
                <div class="flex items-center px-4 py-2 rounded-md hover:bg-gray-100">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <template x-if="sidebarOpen">
                        <div class="flex-1 ml-2">
                            <h4 class="text-sm font-semibold">{{ Auth::user()->name ?? 'Admin User' }}</h4>
                            <span class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@example.com' }}</span>
                        </div>
                    </template>
                </div>
            </div>
        </aside>
        
        <!-- Main content -->
        <div class="flex flex-col flex-1 max-h-screen overflow-hidden">
            <!-- Navbar -->
            <header class="flex-shrink-0 border-b bg-white shadow-sm">
                <div class="flex items-center justify-between p-2">
                    <!-- Left side -->
                    <div class="flex items-center space-x-3">                        
                        <!-- Page heading -->
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            @yield('header')
                        </h2>
                    </div>
                    
                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        <!-- Search bar - Hidden on mobile -->
                        <div class="hidden md:block relative">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input name="search" value="{{ request('search') }}" class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-full md:w-72" type="text" placeholder="Search..." />
                            </form>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-400 rounded-lg hover:text-gray-600 hover:bg-gray-100 relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if(Auth::user() && Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>
                            
                            <!-- Notifications dropdown -->
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-700">Notifications</p>
                                </div>
                                                                
                                @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100 focus:outline-none">
                                            <p class="font-medium">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </button>
                                    </form>
                                @empty
                                    <div class="px-4 py-2 text-sm text-gray-500">
                                        No new notifications
                                    </div>
                                @endforelse
                                
                                <div class="px-4 py-2 border-t border-gray-200">
                                    <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-900">View all notifications</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-1 flex items-center text-sm font-medium rounded-full hover:bg-gray-100">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="hidden md:block ml-2">{{ Auth::user()->name ?? 'Admin User' }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    My Profile
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Settings
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-6">
                <div class="max-w-7xl mx-auto">
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
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
    function sidebar() {
        return {
            open: true,
            toggle() {
                this.open = !this.open;
            }
        };
    }
    window.sidebar = sidebar;
    </script>

    @stack('scripts')
</body>
</html>