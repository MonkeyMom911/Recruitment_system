@extends('layouts.hrd')

@section('header')
    {{ __('Detail Lowongan Pekerjaan') }}
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $jobVacancy->title }}</h3>
                <p class="text-md text-gray-600">{{ $jobVacancy->department }}</p>
            </div>
            <div class="flex space-x-2">
                 <a href="{{ route('hrd.job-vacancies.edit', $jobVacancy) }}" class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600">Edit</a>
                 <a href="{{ route('hrd.job-vacancies.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Kembali</a>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div><strong class="block text-gray-500">Lokasi</strong> {{ $jobVacancy->location }}</div>
            <div><strong class="block text-gray-500">Tipe</strong> {{ ucfirst($jobVacancy->employment_type) }}</div>
            <div><strong class="block text-gray-500">Kuota</strong> {{ $jobVacancy->quota }}</div>
            <div><strong class="block text-gray-500">Gaji</strong> {{ $jobVacancy->salary_range ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Pekerjaan</h3>
        <p class="text-gray-600 whitespace-pre-wrap">{{ $jobVacancy->description }}</p>
        
        <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2">Kualifikasi</h3>
        <div class="text-gray-600 prose max-w-none">{!! nl2br(e($jobVacancy->requirements)) !!}</div>

        <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2">Tanggung Jawab</h3>
        <div class="text-gray-600 prose max-w-none">{!! nl2br(e($jobVacancy->responsibilities)) !!}</div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Pelamar ({{ $applications->total() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lamar</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($applications as $application)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $application->status == 'hired' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('hrd.applications.show', $application) }}" class="text-blue-600 hover:underline">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada pelamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         <div class="p-4 border-t">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection