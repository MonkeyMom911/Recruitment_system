<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Job Vacancy Info -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Job Information</h3>
                <p><strong>Title:</strong> {{ $application->jobVacancy->title }}</p>
                <p><strong>Location:</strong> {{ $application->jobVacancy->location ?? '-' }}</p>
                <p><strong>Posted on:</strong> {{ $application->jobVacancy->created_at->format('d M Y') }}</p>
            </div>

            <!-- Application Status -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Application Status</h3>
                <span class="inline-block px-3 py-1 text-sm rounded-full 
                    @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($application->status === 'accepted') bg-green-100 text-green-800
                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                    @elseif($application->status === 'hired') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($application->status) }}
                </span>
            </div>

            <!-- Submitted Documents -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Submitted Documents</h3>

                <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">

                    {{-- [1] Tampilkan CV Utama yang selalu ada --}}
                    @if ($application->cv_path)
                    <li>
                        <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">
                            CV / Resume
                        </a>
                        <span class="text-xs text-gray-500 ml-2">({{ basename($application->cv_path) }})</span>
                    </li>
                    @endif

                    {{-- [2] Loop untuk menampilkan dokumen tambahan jika ada --}}
                    @foreach ($application->documents as $document)
                        <li>
                            {{-- [3] Gunakan properti 'file_path' dan 'document_type' yang benar --}}
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-indigo-600 hover:underline font-medium">
                                {{ ucfirst($document->document_type) }}
                            </a>
                            <span class="text-xs text-gray-500 ml-2">({{ basename($document->file_path) }})</span>
                        </li>
                    @endforeach
                </ul>

                {{-- [4] Pesan jika tidak ada DOKUMEN TAMBAHAN --}}
                @if($application->documents->isEmpty())
                    <p class="mt-4 text-sm text-gray-500">No additional documents were submitted.</p>
                @endif
            </div>

            <!-- Selection Stages -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Selection Stages</h3>
                @if($application->stages && $application->stages->count())
                    <ul class="text-sm text-gray-700 space-y-2">
                        @foreach ($application->stages as $stage)
                            <li class="border-l-4 pl-3 @if($stage->status === 'completed') border-green-500 @elseif($stage->status === 'rejected') border-red-500 @else border-gray-300 @endif">
                                <strong>{{ $stage->selectionStage->name }}</strong>
                                <div class="text-xs text-gray-500">
                                    Status: {{ ucfirst($stage->status) }} — {{ \Carbon\Carbon::parse($stage->updated_at)->format('d M Y') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No selection stages available.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
