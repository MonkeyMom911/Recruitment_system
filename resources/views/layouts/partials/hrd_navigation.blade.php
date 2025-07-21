<header class="flex-shrink-0 border-b bg-white shadow-sm">
    <div class="flex items-center justify-between p-2">
        {{-- Judul Halaman --}}
        <div class="flex items-center space-x-3">                        
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @yield('header')
            </h2>
        </div>
        
        {{-- Ikon & Menu Sebelah Kanan --}}
        <div class="flex items-center space-x-2 md:space-x-4">
            
            {{-- 1. Dropdown Notifikasi (Kode Langsung) --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if(Auth::user() && Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>
                
                {{-- Panel Dropdown Notifikasi --}}
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-800">Notifikasi</p>
                    </div>
                    
                    <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                        @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-100 focus:outline-none transition">
                                    <p class="font-medium text-sm text-gray-800">{!! $notification->data['message'] ?? 'Notifikasi baru' !!}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </button>
                            </form>
                        @empty
                            <div class="px-4 py-10 text-sm text-center text-gray-500">
                                Tidak ada notifikasi baru.
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="py-2 px-4 border-t border-gray-200 bg-gray-50">
                        <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-blue-600 hover:underline">Lihat semua notifikasi</a>
                    </div>
                </div>
            </div>

            {{-- 2. Dropdown Profil Pengguna --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center text-sm font-medium rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 p-1">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'H', 0, 1)) }}
                    </div>
                    <span class="hidden md:block ml-2 text-gray-700">{{ Auth::user()->name ?? 'HRD User' }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-4 w-4 ml-1 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                {{-- Panel Dropdown Profil --}}
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Profil Saya
                    </a>
                    <hr class="my-1 border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
