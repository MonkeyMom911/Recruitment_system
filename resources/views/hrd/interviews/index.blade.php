@extends('layouts.hrd')

@section('header')
    <h2 class="font-semibold text-2xl text-secondary-800 leading-tight">
        {{ __('Jadwal Interview') }}
    </h2>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Semua Jadwal Interview</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-secondary-500">
            <thead class="text-xs text-secondary-700 uppercase bg-secondary-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal & Waktu</th>
                    <th scope="col" class="px-6 py-3">Nama Pelamar</th>
                    <th scope="col" class="px-6 py-3">Posisi</th>
                    <th scope="col" class="px-6 py-3">Tahap Seleksi</th>
                    <th scope="col" class="px-6 py-3"><span class="sr-only">Lihat</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse($interviews as $interview)
                    <tr class="bg-white border-b hover:bg-secondary-50">
                        <td class="px-6 py-4 font-medium text-secondary-800">
                            {{ \Carbon\Carbon::parse($interview->scheduled_date)->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">{{ $interview->application->user->name }}</td>
                        <td class="px-6 py-4">{{ $interview->application->jobVacancy->title }}</td>
                        <td class="px-6 py-4">{{ $interview->selectionStage->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('hrd.applications.show', $interview->application) }}" class="font-medium text-primary-600 hover:underline">
                                Lihat Lamaran
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-secondary-500">
                            Tidak ada jadwal interview yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $interviews->links() }}
    </div>
</div>
@endsection