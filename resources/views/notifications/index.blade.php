<!-- resources/views/notifications/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Notifications</h3>
                        
                        @if(count($notifications) > 0 && $notifications->where('read_at', null)->count() > 0)
                            <form action="{{ route('notifications.read.all') }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Mark All as Read
                                </button>
                            </form>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(count($notifications) > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($notifications as $notification)
                                <div id="notification-{{ $notification->id }}" class="py-4 px-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium {{ $notification->read_at ? 'text-gray-900' : 'text-blue-800' }}">
                                                {{ $notification->data['message'] ?? 'Notification' }}
                                            </h4>

                                            @php
                                                // Ambil data notifikasi untuk mempermudah
                                                $data = $notification->data;
                                                $type = $data['type'] ?? 'general';
                                            @endphp

                                            {{-- Tampilkan deskripsi berdasarkan tipe notifikasi --}}
                                            @if($type === 'application_submitted')
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Lamaran Anda untuk posisi <span class="font-medium">{{ $data['job_title'] ?? '' }}</span> telah berhasil dikirim.
                                                </p>
                                            @elseif($type === 'status_updated')
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Status lamaran Anda untuk <span class="font-medium">{{ $data['job_title'] ?? '' }}</span> telah diubah ke <span class="font-medium">{{ ucfirst($data['new_status'] ?? '') }}</span>.
                                                </p>
                                            @elseif($type === 'interview_scheduled')
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Jadwal untuk {{ strtolower($data['stage_name'] ?? 'tahap selanjutnya') }} telah ditetapkan pada <span class="font-medium">{{ \Carbon\Carbon::parse($data['scheduled_date'] ?? now())->format('d M Y, H:i') }}</span>.
                                                </p>
                                            @elseif($type === 'new_application')
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Lamaran baru dari <span class="font-medium">{{ $data['applicant_name'] ?? '' }}</span> untuk posisi <span class="font-medium">{{ $data['job_title'] ?? '' }}</span>.
                                                </p>
                                            @elseif($type === 'new_user_registered')
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Pengguna baru, <span class="font-medium">{{ $data['new_user_name'] ?? '' }}</span>, telah mendaftar.
                                                </p>
                                            @elseif($type === 'new_job_vacancy')
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Lowongan baru <span class="font-medium">"{{ $data['job_vacancy_title'] ?? '' }}"</span> telah dibuat oleh <span class="font-medium">{{ $data['creator_name'] ?? '' }}</span>.
                                                </p>
                                            @endif
                                            
                                            {{-- Tampilkan Link Aksi berdasarkan peran dan tipe notifikasi --}}
                                            <div class="mt-2 text-xs">
                                                @if(isset($data['application_id']))
                                                    @if(auth()->user()->isAdmin())
                                                        <a href="{{ route('admin.applications.show', $data['application_id']) }}" class="text-blue-600 hover:text-blue-900">View Application</a>
                                                    @elseif(auth()->user()->isHRD())
                                                        <a href="{{ route('hrd.applications.show', $data['application_id']) }}" class="text-blue-600 hover:text-blue-900">View Application</a>
                                                    @else
                                                        <a href="{{ route('applicant.applications.show', $data['application_id']) }}" class="text-blue-600 hover:text-blue-900">View Application</a>
                                                    @endif
                                                @elseif(isset($data['new_user_id']) && auth()->user()->isAdmin())
                                                    <a href="{{ route('admin.users.show', $data['new_user_id']) }}" class="text-blue-600 hover:text-blue-900">View User</a>
                                                @elseif(isset($data['job_vacancy_id']) && auth()->user()->isAdmin())
                                                    <a href="{{ route('admin.job-vacancies.show', $data['job_vacancy_id']) }}" class="text-blue-600 hover:text-blue-900">View Job Vacancy</a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-4 flex-shrink-0 flex flex-col items-end space-y-2">
                                            <span class="text-xs text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            
                                            @if(!$notification->read_at)
                                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-xs text-blue-600 hover:text-blue-900">Mark as Read</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                You don't have any notifications at the moment.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>