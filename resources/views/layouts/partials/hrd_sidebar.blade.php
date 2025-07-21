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
            <ul class="p-2 overflow-hidden" x-data="{ openDropdown: '{{ request()->routeIs('hrd.reports.*') ? 'reports' : '' }}' }">
                @foreach (config('hrd_nav') as $item)
                    @if(empty($item['sub_menu']))
                        <li>
                            <a href="{{ route($item['route']) }}" class="flex items-center p-2 space-x-2 rounded-md {{ request()->routeIs($item['active_on']) ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                                {!! $item['icon'] !!}
                                <span x-show="sidebarOpen" x-transition.opacity class="truncate">{{ $item['title'] }}</span>
                            </a>
                        </li>
                    @else
                        <li x-data="{ id: '{{ Str::slug($item['title']) }}' }">
                            <button @click="openDropdown = (openDropdown === id ? '' : id)" class="flex items-center justify-between w-full p-2 rounded-md {{ request()->routeIs($item['active_on']) ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
                                <span class="flex items-center space-x-2">
                                    {!! $item['icon'] !!}
                                    <span x-show="sidebarOpen" class="truncate">{{ $item['title'] }}</span>
                                </span>
                                <svg x-show="sidebarOpen" x-bind:class="{ 'transform rotate-180': openDropdown === id }" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="openDropdown === id" class="pl-5 pr-2 py-1" x-transition>
                                <ul class="space-y-1">
                                    @foreach ($item['sub_menu'] as $subItem)
                                        <li>
                                            <a href="{{ route($subItem['route']) }}" class="flex items-center p-2 text-sm rounded-md {{ request()->routeIs($subItem['active_on']) ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                                                <span x-show="sidebarOpen" class="truncate">{{ $subItem['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
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
                    <h4 class="text-sm font-semibold">{{ Auth::user()->name ?? 'HRD User' }}</h4>
                    <span class="text-xs text-gray-500">{{ Auth::user()->email ?? 'hrd@example.com' }}</span>
                </div>
            </template>
        </div>
    </div>
</aside>