<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">                    
                    <x-dynamic-logo {{ $attributes }} />
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('Users') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.job-vacancies.index')" :active="request()->routeIs('admin.job-vacancies.*')">
                                {{ __('Job Vacancies') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.applications.index')" :active="request()->routeIs('admin.applications.*')">
                                {{ __('Applications') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                {{ __('Settings') }}
                            </x-nav-link>
                        @elseif(auth()->user()->isHRD())
                            <x-nav-link :href="route('hrd.dashboard')" :active="request()->routeIs('hrd.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('hrd.job-vacancies.index')" :active="request()->routeIs('hrd.job-vacancies.*')">
                                {{ __('Job Vacancies') }}
                            </x-nav-link>
                            <x-nav-link :href="route('hrd.applications.index')" :active="request()->routeIs('hrd.applications.*')">
                                {{ __('Applications') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('applicant.dashboard')" :active="request()->routeIs('applicant.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('applicant.applications')" :active="request()->routeIs('applicant.applications')">
                                {{ __('My Applications') }}
                            </x-nav-link>
                        @endif
                        
                        <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                            {{ __('Browse Jobs') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                            {{ __('Browse Jobs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Login') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <!-- Notifications -->
                    <div class="mr-3 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-700">Notifications</p>
                                </div>
                                
                               @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    <form @submit.prevent="event.target.submit()" action="{{ route('notifications.read', $notification->id) }}" method="POST" class="block">
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
                    </div>
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('notifications.index')">
                                {{ __('Notifications') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.job-vacancies.index')" :active="request()->routeIs('admin.job-vacancies.*')">
                        {{ __('Job Vacancies') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.applications.index')" :active="request()->routeIs('admin.applications.*')">
                        {{ __('Applications') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isHRD())
                    <x-responsive-nav-link :href="route('hrd.dashboard')" :active="request()->routeIs('hrd.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('hrd.job-vacancies.index')" :active="request()->routeIs('hrd.job-vacancies.*')">
                        {{ __('Job Vacancies') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('hrd.applications.index')" :active="request()->routeIs('hrd.applications.*')">
                        {{ __('Applications') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('applicant.dashboard')" :active="request()->routeIs('applicant.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('applicant.applications')" :active="request()->routeIs('applicant.applications')">
                        {{ __('My Applications') }}
                    </x-responsive-nav-link>
                @endif
                
                <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                    {{ __('Browse Jobs') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                    {{ __('Browse Jobs') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('notifications.index')">
                        {{ __('Notifications') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>