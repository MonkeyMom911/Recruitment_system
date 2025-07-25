<!-- resources/views/admin/users/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New User') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information Section -->
                            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg mb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                                
                                <!-- Name -->
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div class="mb-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-4">
                                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                                    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" />
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                </div>

                                <!-- Role -->
                                <div class="mb-4">
                                    <x-input-label for="role" :value="__('Role')" />
                                    <select id="role" name="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                                        <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }} selected>Applicant</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                                
                                <!-- Password -->
                                <div class="mb-4">
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- Profile Picture -->
                                <div class="mb-4">
                                    <x-input-label for="profile_picture" :value="__('Profile Picture (Optional)')" />
                                    <div class="mt-1 flex items-center">
                                        <div id="profile-picture-preview" class="hidden mr-4 flex-shrink-0 h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                            <img id="preview-image" class="h-16 w-16 rounded-full object-cover" src="" alt="Profile picture preview">
                                        </div>
                                        <input type="file" id="profile_picture" name="profile_picture" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                                    </div>
                                    <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Profile Information Section -->
                            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information (Optional)</h3>
                                
                                <!-- User Profile Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Address -->
                                    <div class="md:col-span-2">
                                        <x-input-label for="address" :value="__('Address')" />
                                        <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>

                                    <!-- City -->
                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" />
                                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                    </div>

                                    <!-- Province -->
                                    <div>
                                        <x-input-label for="province" :value="__('Province')" />
                                        <x-text-input id="province" class="block mt-1 w-full" type="text" name="province" :value="old('province')" />
                                        <x-input-error :messages="$errors->get('province')" class="mt-2" />
                                    </div>

                                    <!-- Postal Code -->
                                    <div>
                                        <x-input-label for="postal_code" :value="__('Postal Code')" />
                                        <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" />
                                        <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                                    </div>

                                    <!-- Date of Birth -->
                                    <div>
                                        <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                        <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                    </div>

                                    <!-- Gender -->
                                    <div>
                                        <x-input-label for="gender" :value="__('Gender')" />
                                        <select id="gender" name="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>

                                    <!-- Bio -->
                                    <div class="md:col-span-2">
                                        <x-input-label for="bio" :value="__('Bio')" />
                                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bio') }}</textarea>
                                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Email Verification -->
                            <div class="md:col-span-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="verify_email" name="verify_email" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('verify_email') ? 'checked' : '' }} checked>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="verify_email" class="font-medium text-gray-700">Mark Email as Verified</label>
                                        <p class="text-gray-500">If checked, the user's email will be marked as verified and they won't need to go through the verification process.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Picture Preview
            const profilePictureInput = document.getElementById('profile_picture');
            const previewContainer = document.getElementById('profile-picture-preview');
            const previewImage = document.getElementById('preview-image');

            profilePictureInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewContainer.classList.add('hidden');
                    previewImage.src = '';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>