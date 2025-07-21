@extends('layouts.hrd')

@section('header')
    {{ __('Manajemen Lowongan') }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="flex items-center justify-between p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Lowongan Pekerjaan Anda</h3>
        <a href="{{ route('hrd.job-vacancies.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
            + Tambah Lowongan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Posisi</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Pelamar</th>
                    <th scope="col" class="px-6 py-3">Tanggal Berakhir</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $vacancy)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <a href="{{ route('hrd.job-vacancies.show', $vacancy) }}" class="hover:text-blue-600">{{ $vacancy->title }}</a>
                        <p class="text-xs text-gray-500 font-normal">{{ $vacancy->department }} - {{ $vacancy->location }}</p>
                    </th>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $vacancy->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($vacancy->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('hrd.applications.index', ['job_vacancy' => $vacancy->id]) }}" class="text-blue-600 hover:underline">
                            {{ $vacancy->applications_count }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $vacancy->end_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('hrd.job-vacancies.show', $vacancy) }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('hrd.job-vacancies.edit', $vacancy) }}" class="font-medium text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('hrd.job-vacancies.destroy', $vacancy) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                        Anda belum membuat lowongan pekerjaan.
                        <a href="{{ route('hrd.job-vacancies.create') }}" class="text-blue-600 hover:underline">Buat sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t">
        {{ $jobVacancies->links() }}
    </div>
</div>
@endsection