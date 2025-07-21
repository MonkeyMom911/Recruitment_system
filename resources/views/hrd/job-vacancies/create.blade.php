@extends('layouts.hrd')

@section('header')
    {{ __('Buat Lowongan Pekerjaan Baru') }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 md:p-8">
        <form action="{{ route('hrd.job-vacancies.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Detail Pekerjaan --}}
            <div class="p-4 border rounded-lg">
                <h3 class="text-lg font-medium mb-4 text-gray-900">Detail Pekerjaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Posisi *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Pekerjaan *</label>
                        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="requirements" class="block text-sm font-medium text-gray-700">Kualifikasi / Persyaratan *</label>
                        <textarea id="requirements" name="requirements" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('requirements') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="responsibilities" class="block text-sm font-medium text-gray-700">Tanggung Jawab *</label>
                        <textarea id="responsibilities" name="responsibilities" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('responsibilities') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Tahapan Seleksi --}}
            <div class="p-4 border rounded-lg" x-data="{ stages: [{name: '', description: ''}] }">
                <h3 class="text-lg font-medium mb-4 text-gray-900">Tahapan Seleksi</h3>
                <p class="text-sm text-gray-500 mb-4">Definisikan tahapan rekrutmen secara berurutan.</p>
                <template x-for="(stage, index) in stages" :key="index">
                    <div class="grid grid-cols-12 gap-4 items-center mb-4 p-2 border-b">
                        <div class="col-span-1 text-center font-bold text-gray-500" x-text="index + 1"></div>
                        <div class="col-span-4">
                            <label :for="'stage_name_' + index" class="text-xs">Nama Tahap *</label>
                            <input :id="'stage_name_' + index" type="text" :name="'stages[' + index + '][name]'" x-model="stage.name" class="w-full mt-1 rounded-md border-gray-300 shadow-sm text-sm" placeholder="e.g., Screening" required>
                        </div>
                        <div class="col-span-6">
                            <label :for="'stage_desc_' + index" class="text-xs">Deskripsi Singkat</label>
                            <input :id="'stage_desc_' + index" type="text" :name="'stages[' + index + '][description]'" x-model="stage.description" class="w-full mt-1 rounded-md border-gray-300 shadow-sm text-sm" placeholder="e.g., Review CV dan portofolio awal">
                        </div>
                        <div class="col-span-1">
                            <button type="button" @click="stages.splice(index, 1)" x-show="stages.length > 1" class="text-red-500 hover:text-red-700 mt-5">&times; Hapus</button>
                        </div>
                    </div>
                </template>
                <button type="button" @click="stages.push({name: '', description: ''})" class="text-sm text-blue-600 hover:text-blue-800">+ Tambah Tahap</button>
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('hrd.job-vacancies.index') }}" class="text-gray-600">Batal</a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Simpan Lowongan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection