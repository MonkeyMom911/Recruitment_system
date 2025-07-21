<!-- resources/views/welcome.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(key: 'Welcome') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6">Find Your Dream Job</h1>
                        <p class="text-lg text-gray-600 mb-8">Discover opportunities that match your skills and aspirations. Join our team of talented professionals.</p>
                        
                        <div class="mt-10 space-y-4 sm:space-y-0 sm:flex sm:justify-center sm:gap-6">
                            <a href="{{ route('jobs.index') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 sm:px-8">
                                Browse Jobs
                            </a>
                            @guest
                                <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-blue-700 bg-blue-100 hover:bg-blue-200 sm:px-8">
                                    Create Account
                                </a>
                            @else
                                <a href="{{ auth()->user()->isApplicant() ? route('applicant.dashboard') : (auth()->user()->isHRD() ? route('hrd.dashboard') : route('admin.dashboard')) }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-blue-700 bg-blue-100 hover:bg-blue-200 sm:px-8">
                                    Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>

                    <!-- Featured Jobs Section -->
                    <div class="mt-16">
                        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">Featured Positions</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- We'll dynamically load featured jobs here -->
                            <div class="p-6 border rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                <h3 class="text-xl font-semibold text-gray-900 hover:text-blue-600">
                                    <a href="{{ route('jobs.index') }}">Senior Web Developer</a>
                                </h3>
                                <p class="mt-2 text-base text-gray-500">
                                    We're looking for a skilled web developer with experience in modern frameworks to join our development team.
                                </p>
                                <div class="mt-4 flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Yogyakarta, Indonesia
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Full-time
                                    </span>
                                    <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-900">
                                        View Details &rarr;
                                    </a>
                                </div>
                            </div>

                            <div class="p-6 border rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                <h3 class="text-xl font-semibold text-gray-900 hover:text-blue-600">
                                    <a href="{{ route('jobs.index') }}">UI/UX Designer</a>
                                </h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Join our creative team to design intuitive and beautiful user experiences for our products and services.
                                </p>
                                <div class="mt-4 flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Bantul, Yogyakarta
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Remote
                                    </span>
                                    <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-900">
                                        View Details &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                View All Positions
                            </a>
                        </div>
                    </div>

                    <!-- About Company Section -->
                    <div class="mt-16">
                        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">About PT. Winnicode Garuda Teknologi</h2>
                        
                        <div class="prose prose-blue lg:prose-lg mx-auto">
                            <p>
                                PT. Winnicode Garuda Teknologi, founded in 2020, is a digital technology company based in Bantul, Yogyakarta. 
                                We specialize in web development, mobile applications, and digital transformation solutions for businesses of all sizes.
                            </p>
                            <p>
                                Our team consists of passionate professionals who are dedicated to creating innovative solutions that help our clients 
                                succeed in the digital landscape. We believe in continuous learning, collaboration, and delivering high-quality work 
                                that exceeds expectations.
                            </p>
                            <p>
                                As we continue to grow, we're always looking for talented individuals to join our team. We offer a dynamic work environment, 
                                competitive compensation, and opportunities for professional development.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

