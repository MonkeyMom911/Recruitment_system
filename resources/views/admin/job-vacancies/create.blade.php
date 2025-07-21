<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Job Vacancy (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    {{-- [PERUBAHAN 1] Mengarah ke route admin --}}
                    <form action="{{ route('admin.job-vacancies.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Job Details Section --}}
                        <div class="p-4 border rounded-lg">
                            <h3 class="text-lg font-medium mb-4 text-gray-900">Job Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="title" :value="__('Job Title *')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="department" :value="__('Department *')" />
                                    <x-text-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department')" required />
                                    <x-input-error :messages="$errors->get('department')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="location" :value="__('Location *')" />
                                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="employment_type" :value="__('Employment Type *')" />
                                    <select id="employment_type" name="employment_type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                        <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                        <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="salary_range" :value="__('Salary Range *')" />
                                    <x-text-input id="salary_range" class="block mt-1 w-full" type="text" name="salary_range" :value="old('salary_range')" placeholder="e.g., 8.000.000 - 10.000.000" required/>
                                </div>
                                <div>
                                    <x-input-label for="quota" :value="__('Quota *')" />
                                    <x-text-input id="quota" class="block mt-1 w-full" type="number" name="quota" :value="old('quota', 1)" required min="1" />
                                    <x-input-error :messages="$errors->get('quota')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="active" selected>Active</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="start_date" :value="__('Start Date *')" />
                                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="end_date" :value="__('End Date *')" />
                                    <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="description" :value="__('Job Description *')" />
                                    <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="requirements" :value="__('Requirements *')" />
                                    <textarea id="requirements" name="requirements" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('requirements') }}</textarea>
                                    <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="responsibilities" :value="__('Responsibilities *')" />
                                    <textarea id="responsibilities" name="responsibilities" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('responsibilities') }}</textarea>
                                    <x-input-error :messages="$errors->get('responsibilities')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Selection Stages Section --}}
                        <div class="p-4 border rounded-lg" x-data="{ stages: [{name: '', description: ''}] }">
                            <h3 class="text-lg font-medium mb-4 text-gray-900">Selection Stages</h3>
                            <p class="text-sm text-gray-500 mb-4">Define the recruitment stages for this position in sequence. E.g., 1. Screening, 2. HR Interview, 3. Technical Test.</p>
                            <template x-for="(stage, index) in stages" :key="index">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center mb-4 p-2 border-b">
                                    <div class="md:col-span-1 text-center font-bold text-gray-500" x-text="index + 1"></div>
                                    <div class="md:col-span-4">
                                        <x-input-label ::for="'stage_name_' + index" value="Stage Name" class="text-xs" />
                                        <x-text-input ::id="'stage_name_' + index" type="text" ::name="'stages[' + index + '][name]'" x-model="stage.name" class="w-full mt-1" placeholder="e.g., Screening" required />
                                    </div>
                                    <div class="md:col-span-6">
                                        <x-input-label ::for="'stage_desc_' + index" value="Description" class="text-xs" />
                                        <x-text-input ::id="'stage_desc_' + index" type="text" ::name="'stages[' + index + '][description]'" x-model="stage.description" class="w-full mt-1" placeholder="e.g., Initial CV review" />
                                    </div>
                                    <div class="md:col-span-1">
                                        <button type="button" @click="stages.splice(index, 1)" x-show="stages.length > 1" class="text-red-500 hover:text-red-700 mt-5">&times; Remove</button>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="stages.push({name: '', description: ''})" class="text-sm text-blue-600 hover:text-blue-800">+ Add Stage</button>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            {{-- [PERUBAHAN 2] Link cancel mengarah ke route admin --}}
                            <a href="{{ route('admin.job-vacancies.index') }}" class="text-gray-600">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Job Vacancy') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>