<!-- resources/views/applications/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Apply for: {{ $jobVacancy->title }}
            </h2>
            <a href="{{ route('jobs.show', $jobVacancy->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Job Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Job Information -->
                    <div class="mb-8 border-b pb-4">
                        <h3 class="text-lg font-medium text-gray-900">Job Information</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Position</p>
                                <p class="mt-1 font-medium">{{ $jobVacancy->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Department</p>
                                <p class="mt-1 font-medium">{{ $jobVacancy->department }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="mt-1 font-medium">{{ $jobVacancy->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Employment Type</p>
                                <p class="mt-1 font-medium">{{ ucfirst($jobVacancy->employment_type) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Application Form -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Application Form</h3>
                        
                        <form action="{{ route('applications.store', $jobVacancy->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Personal Information -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-4">Personal Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="name" :value="__('Full Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', auth()->user()->name)" readonly />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        <p class="mt-1 text-xs text-gray-500">To update your name, please edit your profile.</p>
                                    </div>
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', auth()->user()->email)" readonly />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        <p class="mt-1 text-xs text-gray-500">To update your email, please edit your profile.</p>
                                    </div>
                                    <div>
                                        <x-input-label for="phone" :value="__('Phone Number')" />
                                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', auth()->user()->phone_number)" readonly />
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                        <p class="mt-1 text-xs text-gray-500">To update your phone number, please edit your profile.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Application Documents -->
                           <div>
                                <x-input-label for="cv" :value="__('Resume/CV *')" />
                                    
                                    {{-- [1] Komponen Alpine.js untuk mengelola state tampilan --}}
                                    <div x-data="{ cvName: null }" class="mt-1">
                                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                
                                                {{-- [2] Tampilan Placeholder saat belum ada file --}}
                                                <div x-show="!cvName" class="transition-all">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label for="cv" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                            <span>Upload your CV</span>
                                                            {{-- [3] HANYA ADA SATU INPUT FILE DI SINI --}}
                                                            <input id="cv" name="cv" type="file" class="sr-only" 
                                                                x-ref="cvInput" 
                                                                @change="cvName = $event.target.files[0] ? $event.target.files[0].name : null" 
                                                                accept=".pdf,.doc,.docx" required>
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 2MB</p>
                                                </div>

                                                {{-- [4] Tampilan Pratinjau setelah file dipilih --}}
                                                <div x-show="cvName" class="transition-all" style="display: none;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    <p class="mt-2 text-sm text-gray-900">File Selected:</p>
                                                    <p class="text-sm font-medium text-gray-700" x-text="cvName"></p>
                                                    <button type="button" @click="cvName = null; $refs.cvInput.value = null;" class="mt-2 text-xs text-red-600 hover:underline">
                                                        Remove file
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                            </div>

                                    <!-- Cover Letter -->
                                    <div>
                                        <x-input-label for="cover_letter" :value="__('Cover Letter *')" />
                                        <textarea id="cover_letter" name="cover_letter" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tell us why you're interested in this position and why you'd be a good fit...">{{ old('cover_letter') }}</textarea>
                                        <x-input-error :messages="$errors->get('cover_letter')" class="mt-2" />
                                    </div>

                                    <!-- Expected Salary -->
                                {{-- Kode Baru untuk Expected Salary --}}
                                <div>
                                    <x-input-label for="expected_salary" :value="__('Expected Salary *')" />

                                    @php
                                        $salaryOptions = [];
                                        $salaryRange = $jobVacancy->salary_range;

                                        if ($salaryRange) {
                                            // 1. Membersihkan string dari "Rp", titik, dan spasi
                                            $cleanedRange = preg_replace('/[^0-9-]/', '', $salaryRange);
                                            $parts = explode('-', $cleanedRange);

                                            // 2. Memeriksa apakah ada rentang yang valid (terdiri dari min dan max)
                                            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                                                $min = (int)$parts[0];
                                                $max = (int)$parts[1];
                                                // Menentukan jumlah step (opsi) yang akan dibuat
                                                $steps = ($max - $min) / 500000 > 8 ? 8 : (int)(($max - $min) / 500000); 
                                                $increment = ($max - $min > 0 && $steps > 0) ? floor(($max - $min) / ($steps + 1)) : 0;

                                                // Tambahkan gaji minimum sebagai opsi pertama
                                                $salaryOptions[$min] = 'Rp ' . number_format($min, 0, ',', '.');

                                                // Buat beberapa opsi di antara min dan max
                                                if ($increment > 0) {
                                                    for ($i = 1; $i <= $steps; $i++) {
                                                        $value = $min + ($i * $increment);
                                                        // Bulatkan ke ratusan ribu terdekat untuk angka yang rapi
                                                        $value = round($value / 100000) * 100000;
                                                        if ($value < $max) {
                                                            $salaryOptions[$value] = 'Rp ' . number_format($value, 0, ',', '.');
                                                        }
                                                    }
                                                }
                                                // Tambahkan gaji maksimum sebagai opsi terakhir
                                                $salaryOptions[$max] = 'Rp ' . number_format($max, 0, ',', '.');
                                            }
                                        }
                                    @endphp

                                    @if(!empty($salaryOptions))
                                        {{-- [A] Tampilkan Dropdown jika rentang gaji tersedia --}}
                                        <select name="expected_salary" id="expected_salary" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="" disabled selected>-- Select an expected salary --</option>
                                            @foreach($salaryOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('expected_salary') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-xs text-gray-500">Please select one of the salary options according to the specified range.</p>

                                    @else
                                        {{-- [B] Tampilkan Input Angka biasa jika rentang tidak valid atau tidak ada --}}
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="number" name="expected_salary" id="expected_salary" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Enter your expected salary" value="{{ old('expected_salary') }}">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">/month</span>
                                            </div>
                                        </div>
                                    @endif
                                    <x-input-error :messages="$errors->get('expected_salary')" class="mt-2" />
                                </div>


                            <!-- Additional Documents -->
                                {{-- Kode Baru untuk Additional Documents --}}
                        <div x-data="{
                            documents: [{ id: 1, type: 'certificate', showInput: true, file: null }],
                            nextId: 2,
                            addDocument() {
                                if (this.documents.length < 5) {
                                    this.documents.push({ id: this.nextId++, type: 'certificate', showInput: false, file: null });
                                } else {
                                    alert('You can upload a maximum of 5 additional documents.');
                                }
                            },
                            removeDocument(id) {
                                this.documents = this.documents.filter(doc => doc.id !== id);
                            }
                        }">
                            <x-input-label :value="__('Additional Documents (Optional)')" />
                            <div class="mt-1">
                                <div class="space-y-4">
                                    {{-- [1] Loop dinamis menggunakan Alpine.js --}}
                                    <template x-for="(doc, index) in documents" :key="doc.id">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-1/3">
                                                {{-- [2] Dropdown untuk memilih tipe dokumen --}}
                                                <select :name="'document_types[' + index + ']'" x-model="doc.type" @change="doc.showInput = true"
                                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                    <option value="certificate">Certificate</option>
                                                    <option value="portfolio">Portfolio</option>
                                                    <option value="recommendation">Recommendation Letter</option>
                                                    <option value="id_card">ID Card</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="w-2/3 flex items-center">
                                                {{-- [3] Input file yang tampil secara kondisional --}}
                                                <div x-show="doc.showInput" class="w-full">
                                                    <input :name="'additional_documents[' + index + ']'" type="file"
                                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                </div>
                                            </div>
                                            {{-- [4] Tombol untuk menghapus baris --}}
                                            <button type="button" @click="removeDocument(doc.id)" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="addDocument" class="mt-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Document
                                </button>
                            </div>
                        </div>
                                    
                            <!-- Confirmation and Agreement -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-4">Agreement</h4>
                                <div class="space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="agreement" name="agreement" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="agreement" class="font-medium text-gray-700">I agree to the terms and conditions</label>
                                            <p class="text-gray-500">By applying for this position, I confirm that all information provided is accurate and complete. I understand that any false statements or omissions may disqualify me from further consideration for employment.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="data_permission" name="data_permission" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="data_permission" class="font-medium text-gray-700">Data processing permission</label>
                                            <p class="text-gray-500">I consent to PT. Winnicode Garuda Teknologi processing my personal data for recruitment purposes. I understand that my data will be stored securely and will not be shared with third parties without my consent.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CV Preview
            const cvInput = document.getElementById('cv');
            const cvPreview = document.getElementById('cv-preview');
            const cvName = document.getElementById('cv-name');

            cvInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    cvName.textContent = this.files[0].name;
                    cvPreview.classList.remove('hidden');
                } else {
                    cvPreview.classList.add('hidden');
                }
            });

            // Add Additional Document
            const addDocumentBtn = document.getElementById('add-document');
            const additionalDocumentsContainer = document.getElementById('additional-documents');

            addDocumentBtn.addEventListener('click', function() {
                const documentCount = additionalDocumentsContainer.children.length;
                if (documentCount >= 5) {
                    alert('You can upload a maximum of 5 additional documents.');
                    return;
                }

                const documentRow = document.createElement('div');
                documentRow.className = 'flex items-center space-x-4';
                documentRow.innerHTML = `
                    <div class="w-1/3">
                        <select name="document_types[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="certificate">Certificate</option>
                            <option value="portfolio">Portfolio</option>
                            <option value="recommendation">Recommendation Letter</option>
                            <option value="id_card">ID Card</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="w-2/3 flex items-center">
                        <input type="file" name="additional_documents[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <button type="button" class="remove-document ml-2 text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                `;

                additionalDocumentsContainer.appendChild(documentRow);

                // Add event listener to remove button
                const removeButton = documentRow.querySelector('.remove-document');
                removeButton.addEventListener('click', function() {
                    additionalDocumentsContainer.removeChild(documentRow);
                });
            });
        });
    </script>
    @endpush
</x-app-layout>