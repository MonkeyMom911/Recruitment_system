@extends('layouts.hrd')

@section('header')
    {{ __('HRD Dashboard') }}
@endsection

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="p-5 bg-white rounded-lg shadow transition-transform transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Lowongan Aktif Anda</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeVacancies }}</p>
                </div>
            </div>
        </div>

        <div class="p-5 bg-white rounded-lg shadow transition-transform transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                     <svg class="w-6 h-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Lamaran Masuk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalApplications }}</p>
                </div>
            </div>
        </div>

        <div class="p-5 bg-white rounded-lg shadow transition-transform transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Lamaran Baru (7 hari)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $applicationsLast7Days }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
        <div class="lg:col-span-3 p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Distribusi Status Lamaran</h3>
            <div class="relative h-80">
                <canvas id="applicationStatusChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 p-6 bg-white rounded-lg shadow">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Jadwal Interview Mendatang</h3>
            <div class="space-y-4">
                @forelse ($upcomingInterviews as $interview)
                <div class="p-3 transition bg-gray-50 rounded-md hover:bg-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-sm text-gray-800">{{ $interview->application->user->name }}</p>
                            <p class="text-xs text-gray-500">Untuk: <span class="font-medium">{{ $interview->application->jobVacancy->title }}</span></p>
                            <p class="text-xs text-gray-500">Tahap: <span class="font-medium">{{ $interview->selectionStage->name }}</span></p>
                        </div>
                        <div class="text-right text-sm">
                            <p class="font-semibold text-blue-600">{{ \Carbon\Carbon::parse($interview->scheduled_date)->format('d M') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($interview->scheduled_date)->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-gray-500">
                    <p>Tidak ada jadwal interview.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Lamaran Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($recentApplications as $application)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $application->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $application->jobVacancy->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('hrd.applications.show', $application) }}" class="text-blue-600 hover:underline">Lihat Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada lamaran terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusData = @json($applicationStatuses);
        const ctx = document.getElementById('applicationStatusChart').getContext('2d');

        if (Object.keys(statusData).length > 0) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(107, 114, 128, 0.7)', // applied
                            'rgba(59, 130, 246, 0.7)',  // screening
                            'rgba(139, 92, 246, 0.7)',  // interview
                            'rgba(245, 158, 11, 0.7)',  // test
                            'rgba(16, 185, 129, 0.7)',  // hired
                            'rgba(239, 68, 68, 0.7)'    // rejected
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                boxWidth: 12
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        }
    });
</script>
@endpush
@endsection