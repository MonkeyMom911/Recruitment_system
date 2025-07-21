@extends('layouts.hrd')

@section('header')
    {{ __('Manajemen Lamaran') }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Lamaran</h3>
        <form action="{{ route('hrd.applications.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Pelamar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Nama atau email...">
            </div>
             <div>
                <label for="job_vacancy" class="block text-sm font-medium text-gray-700">Posisi Lowongan</label>
                <select id="job_vacancy" name="job_vacancy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Posisi</option>
                    @foreach($jobVacancies as $id => $title)
                        <option value="{{ $id }}" {{ request('job_vacancy') == $id ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Status</option>
                    {{-- OPSI STATUS LENGKAP --}}
                    <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                    <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Screening</option>
                    <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                    <option value="test" {{ request('status') == 'test' ? 'selected' : '' }}>Test</option>
                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex space-x-2">
                 <button type="submit" class="w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">Filter</button>
                 <a href="{{ route('hrd.applications.index') }}" class="w-full text-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Reset</a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lamar</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($applications as $application)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $application->jobVacancy->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- LOGIKA WARNA STATUS --}}
                        <span class="px-2 py-1 text-xs font-medium rounded-full capitalize 
                            @switch($application->status)
                                @case('hired')
                                    bg-green-100 text-green-800
                                    @break
                                @case('rejected')
                                    bg-red-100 text-red-800
                                    @break
                                @case('interview')
                                @case('test')
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @default
                                    bg-blue-100 text-blue-800
                            @endswitch
                        ">
                            {{ $application->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <a href="{{ route('hrd.applications.show', $application) }}" class="text-blue-600 hover:underline">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Tidak ada data lamaran yang cocok.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t">
        {{ $applications->withQueryString()->links() }}
    </div>
</div>
@endsection
