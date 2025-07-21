@extends('layouts.hrd')

@section('header')
    {{ __('Laporan Lamaran Pekerjaan') }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow">
    {{-- Filter Form --}}
    <div class="p-4 border-b">
        <form action="{{ route('hrd.reports.applications') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
                {{-- Filter Tanggal Mulai --}}
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                {{-- Filter Tanggal Selesai --}}
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                {{-- Filter Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                        <option value="">Semua Status</option>
                        <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                        <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Screening</option>
                        <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="test" {{ request('status') == 'test' ? 'selected' : '' }}>Test</option>
                        <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                {{-- Tombol Aksi --}}
                <div class="flex space-x-2">
                    <button type="submit" class="w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('hrd.reports.applications') }}" class="w-full text-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Reset
                    </a>
                </div>
                {{-- Tombol Export --}}
                <div class="lg:text-right">
                    <a href="{{ route('hrd.reports.export', array_merge(request()->query(), ['type' => 'applications'])) }}" class="inline-flex items-center justify-center w-full lg:w-auto py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        Export Excel
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel Laporan --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi Dilamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Melamar</th>
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
                        <span class="px-2 py-1 text-xs font-medium rounded-full capitalize 
                            {{ $application->status == 'hired' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $application->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                            {{ in_array($application->status, ['applied', 'screening', 'interview', 'test']) ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ $application->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">Tidak ada data lamaran yang cocok dengan filter Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi --}}
    <div class="p-4 border-t">
        {{ $applications->withQueryString()->links() }}
    </div>
</div>
@endsection
