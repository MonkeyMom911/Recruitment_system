@extends('layouts.hrd')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Lamaran') }}
        </h2>
        <a href="{{ route('hrd.applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Lamaran
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Lamaran untuk: {{ $application->jobVacancy->title }}</h3>
                    <div class="mt-2 flex items-center">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full capitalize
                            @switch($application->status)
                                @case('hired') bg-green-100 text-green-800 @break
                                @case('rejected') bg-red-100 text-red-800 @break
                                @case('interview') bg-purple-100 text-purple-800 @break
                                @case('test') bg-yellow-100 text-yellow-800 @break
                                @case('screening') bg-blue-100 text-blue-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            {{ str_replace('_', ' ', $application->status) }}
                        </span>
                        <span class="ml-3 text-sm text-gray-500">
                            Tanggal Melamar: {{ $application->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- [PERUBAHAN] Blok "Catatan & Aksi" dipindahkan ke luar dari grid ini --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelamar</h3>
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-16 w-16">
                            <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-white font-medium text-xl">
                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $application->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                            <p class="text-sm text-gray-600">{{ $application->user->profile->phone_number ?? 'No phone number' }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="mailto:{{ $application->user->email }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Email Pelamar
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen Lamaran</h3>
                    <ul class="divide-y divide-gray-200">
                        @if ($application->cv_path)
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center min-w-0">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2-2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">CV / Resume</p>
                                    <p class="text-xs text-gray-500 truncate">{{ basename($application->cv_path) }}</p>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 text-sm">
                                    Lihat
                                </a>
                            </div>
                        </li>
                        @endif
                        
                        @foreach($application->documents as $document)
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center min-w-0">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2-2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ basename($document->file_path) }}</p>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="{{ route('hrd.applications.documents.show', ['application' => $application->id, 'document' => $document->id]) }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 text-sm">
                                    Lihat
                                </a>
                            </div>
                        </li>
                        @endforeach
                        
                        @if($application->documents->isEmpty() && !$application->cv_path)
                        <li class="py-3 text-sm text-gray-500 text-center">
                            Tidak ada dokumen yang diunggah.
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Progres Seleksi</h3>
                    <ol class="relative border-l border-gray-200">                  
                        @foreach($application->stages->sortBy('selectionStage.sequence') as $stage)
                        {{-- [PERUBAHAN] class pada <li> disederhanakan --}}
                        <li class="mb-10 relative">  
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                                @if($stage->status === 'passed')
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                @elseif($stage->status === 'failed')
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                @else
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                @endif
                            </span>
                            {{-- [PERUBAHAN] Margin kiri (ml-6) diganti menjadi (ml-8) agar lebih lebar --}}
                            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm ml-8">
                                <div class="items-center justify-between mb-3 sm:flex">
                                    <div class="text-sm font-semibold text-gray-900 flex items-center">
                                        <span>{{ $stage->selectionStage->name }}</span>
                                        <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full capitalize @if($stage->status === 'passed') bg-green-100 text-green-800 @elseif($stage->status === 'failed') bg-red-100 text-red-800 @else bg-gray-100 text-gray-800 @endif">
                                            {{ $stage->status }}
                                        </span>
                                    </div>
                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                        @if($stage->completed_date)
                                            Selesai pada {{ $stage->completed_date->format('d M Y') }}
                                        @elseif($stage->scheduled_date)
                                            Dijadwalkan pada {{ \Carbon\Carbon::parse($stage->scheduled_date)->format('d M Y, H:i') }}
                                        @endif
                                    </time>
                                </div>
                                <div class="p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50">
                                   {{ $stage->notes ?? $stage->selectionStage->description }}
                                </div>

                                @can('update', $application)
                                    @if($stage->status === 'pending')
                                    <div class="mt-4 pt-4 border-t" x-data="{ openAction: '' }">
                                        <div class="flex space-x-2">
                                            <button @click="openAction = (openAction === 'update' ? '' : 'update')" class="text-xs text-blue-600 hover:underline">Update Hasil</button>
                                            @if(in_array(strtolower($stage->selectionStage->name), ['interview', 'test']))
                                                <span class="text-gray-300">|</span>
                                                <button @click="openAction = (openAction === 'schedule' ? '' : 'schedule')" class="text-xs text-blue-600 hover:underline">Jadwalkan</button>
                                            @endif
                                        </div>

                                        <form x-show="openAction === 'update'" x-transition action="{{ route('hrd.application-stages.update', $stage) }}" method="POST" class="mt-3 space-y-2 bg-gray-50 p-3 rounded-md">
                                            @csrf
                                            @method('PATCH')
                                            <h5 class="text-sm font-semibold">Update Hasil Tahap</h5>
                                            <div>
                                                <label for="stage_status_{{ $stage->id }}" class="text-xs font-medium text-gray-700">Hasil</label>
                                                <select name="status" id="stage_status_{{ $stage->id }}" class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
                                                    <option value="pending" selected>Pending</option>
                                                    <option value="passed">Lulus</option>
                                                    <option value="failed">Gagal</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="score_{{ $stage->id }}" class="text-xs font-medium text-gray-700">Skor (Opsional)</label>
                                                <input type="number" name="score" id="score_{{ $stage->id }}" class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm" placeholder="0-100">
                                            </div>
                                            <div>
                                                <label for="stage_notes_{{ $stage->id }}" class="text-xs font-medium text-gray-700">Catatan (Opsional)</label>
                                                <textarea name="notes" id="stage_notes_{{ $stage->id }}" rows="2" class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm"></textarea>
                                            </div>
                                            <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Simpan Hasil</button>
                                        </form>

                                        @if(in_array(strtolower($stage->selectionStage->name), ['interview', 'test']))
                                        <form x-show="openAction === 'schedule'" x-transition action="{{ route('hrd.application-stages.schedule', $stage) }}" method="POST" class="mt-3 space-y-2 bg-gray-50 p-3 rounded-md">
                                            @csrf
                                            <h5 class="text-sm font-semibold">Jadwalkan Tahap</h5>
                                            <div>
                                                <label for="scheduled_date_{{ $stage->id }}" class="text-xs font-medium text-gray-700">Tanggal & Waktu</label>
                                                <input type="datetime-local" id="scheduled_date_{{ $stage->id }}" name="scheduled_date" class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                                            </div>
                                            <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Set Jadwal</button>
                                        </form>
                                        @endif
                                    </div>
                                    @endif
                                @endcan
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>{{-- [PERUBAHAN] Ini adalah akhir dari div.grid --}}

    {{-- [PERUBAHAN] Blok "Catatan & Aksi" sekarang berada di luar grid dan akan menjadi full-width. --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Catatan & Aksi</h3>
            @if($application->notes)
                <div class="bg-gray-50 p-4 rounded-md mb-4 text-sm text-gray-800 whitespace-pre-wrap h-32 overflow-y-auto">{{ $application->notes }}</div>
            @else
                <div class="text-sm text-gray-500 mb-4">Belum ada catatan untuk lamaran ini.</div>
            @endif

            @can('update', $application)
            <div class="space-y-4">
                 <form action="{{ route('hrd.applications.notes.add', $application) }}" method="POST">
                    @csrf
                    <label for="notes" class="block text-sm font-medium text-gray-700">Tambah Catatan Baru</label>
                    <textarea name="notes" id="notes" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm" placeholder="Tulis catatan di sini..."></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700">Simpan Catatan</button>
                </form>
                <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" class="pt-4 border-t">
                    @csrf
                    @method('PATCH')
                     <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status Keseluruhan</label>
                    <div class="mt-1 flex items-center space-x-2">
                        <select id="status" name="status" class="block w-full rounded-md border-gray-300 shadow-sm">
                            @php $statuses = ['applied', 'screening', 'interview', 'test', 'hired', 'rejected']; @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $application->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
            @endcan
        </div>
    </div>

@endsection