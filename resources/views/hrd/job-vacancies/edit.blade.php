@extends('layouts.hrd')

@section('header')
    {{ __('Edit Lowongan Pekerjaan') }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <h3 class="text-xl font-semibold text-gray-900">{{ $jobVacancy->title }}</h3>
        <p class="text-sm text-gray-500">Perbarui detail untuk lowongan pekerjaan ini.</p>
    </div>

    <div class="p-6 md:p-8">
        {{-- Menampilkan pesan error validasi --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan data yang Anda masukkan.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hrd.job-vacancies.update', $jobVacancy->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Detail Pekerjaan --}}
            <div class="p-4 border rounded-lg">
                <h3 class="text-lg font-medium mb-4 text-gray-900">Detail Pekerjaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Judul Posisi --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Posisi *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $jobVacancy->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    {{-- Departemen --}}
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700">Departemen *</label>
                        <input type="text" id="department" name="department" value="{{ old('department', $jobVacancy->department) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Lokasi *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $jobVacancy->location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    {{-- Tipe Pekerjaan --}}
                    <div>
                        <label for="employment_type" class="block text-sm font-medium text-gray-700">Tipe Pekerjaan *</label>
                        <select id="employment_type" name="employment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="full-time" {{ old('employment_type', $jobVacancy->employment_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="part-time" {{ old('employment_type', $jobVacancy->employment_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="contract" {{ old('employment_type', $jobVacancy->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="internship" {{ old('employment_type', $jobVacancy->employment_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>

                    {{-- Rentang Gaji --}}
                    <div>
                        <label for="salary_range" class="block text-sm font-medium text-gray-700">Rentang Gaji (Opsional)</label>
                        <input type="text" id="salary_range" name="salary_range" value="{{ old('salary_range', $jobVacancy->salary_range) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., 5.000.000 - 7.000.000">
                    </div>

                    {{-- Kuota --}}
                    <div>
                        <label for="quota" class="block text-sm font-medium text-gray-700">Kuota *</label>
                        <input type="number" id="quota" name="quota" value="{{ old('quota', $jobVacancy->quota) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required min="1">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ old('status', $jobVacancy->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="closed" {{ old('status', $jobVacancy->status) == 'closed' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>
                    
                    {{-- Tanggal Mulai --}}
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai *</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $jobVacancy->start_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai *</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $jobVacancy->end_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Pekerjaan *</label>
                        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('description', $jobVacancy->description) }}</textarea>
                    </div>

                    {{-- Kualifikasi --}}
                    <div class="md:col-span-2">
                        <label for="requirements" class="block text-sm font-medium text-gray-700">Kualifikasi / Persyaratan *</label>
                        <textarea id="requirements" name="requirements" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('requirements', $jobVacancy->requirements) }}</textarea>
                    </div>

                    {{-- Tanggung Jawab --}}
                    <div class="md:col-span-2">
                        <label for="responsibilities" class="block text-sm font-medium text-gray-700">Tanggung Jawab *</label>
                        <textarea id="responsibilities" name="responsibilities" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('responsibilities', $jobVacancy->responsibilities) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('hrd.job-vacancies.show', $jobVacancy->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Lowongan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
