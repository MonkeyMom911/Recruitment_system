<!-- resources/views/admin/settings/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Settings') }}
        </h2>
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

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- General Settings Section -->
                            <div class="col-span-1 md:col-span-2 p-4 bg-gray-50 rounded-lg mb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">General Settings</h3>
                                
                                <!-- Site Name -->
                                <div class="mb-4">
                                    <x-input-label for="site_name" :value="__('Site Name')" />
                                    <x-text-input id="site_name" class="block mt-1 w-full" type="text" name="site_name" :value="old('site_name', $settings['site_name'])" required />
                                    <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                                </div>

                                <!-- Site Description -->
                                <div class="mb-4">
                                    <x-input-label for="site_description" :value="__('Site Description')" />
                                    <textarea id="site_description" name="site_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('site_description', $settings['site_description']) }}</textarea>
                                    <x-input-error :messages="$errors->get('site_description')" class="mt-2" />
                                </div>

                                <!-- Logo -->
                                <div class="mb-4">
                                    <x-input-label for="logo" :value="__('Logo')" />
                                    <div class="mt-1 flex items-center">
                                        @if (!empty($settings['logo']))
                                            <div class="mt-4">
                                                <p class="text-gray-600">Current Logo:</p>
                                                <img src="{{ $settings['logo'] }}" alt="Current Logo" class="mt-2 h-20 w-auto">
                                            </div>
                                        @endif
                                        <input type="file" id="logo" name="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                                    </div>
                                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                                    <div class="mt-1 text-sm text-gray-500">
                                        Recommended size: 200x200 pixels. Leave blank to keep current logo.
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="col-span-1 p-4 bg-gray-50 rounded-lg mb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                                
                                <!-- Contact Email -->
                                <div class="mb-4">
                                    <x-input-label for="contact_email" :value="__('Contact Email')" />
                                    <x-text-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="old('contact_email', $settings['contact_email'])" required />
                                    <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                                </div>

                                <!-- Contact Phone -->
                                <div class="mb-4">
                                    <x-input-label for="contact_phone" :value="__('Contact Phone')" />
                                    <x-text-input id="contact_phone" class="block mt-1 w-full" type="text" name="contact_phone" :value="old('contact_phone', $settings['contact_phone'])" />
                                    <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                                </div>

                                <!-- Company Address -->
                                <div class="mb-4">
                                    <x-input-label for="company_address" :value="__('Company Address')" />
                                    <textarea id="company_address" name="company_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('company_address', $settings['company_address']) }}</textarea>
                                    <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Social Media Section -->
                            <div class="col-span-1 p-4 bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media</h3>
                                
                                <!-- Facebook -->
                                <div class="mb-4">
                                    <x-input-label for="social_facebook" :value="__('Facebook URL')" />
                                    <x-text-input id="social_facebook" class="block mt-1 w-full" type="url" name="social_facebook" :value="old('social_facebook', $settings['social_facebook'])" placeholder="https://facebook.com/yourpage" />
                                    <x-input-error :messages="$errors->get('social_facebook')" class="mt-2" />
                                </div>

                                <!-- Twitter -->
                                <div class="mb-4">
                                    <x-input-label for="social_twitter" :value="__('Twitter URL')" />
                                    <x-text-input id="social_twitter" class="block mt-1 w-full" type="url" name="social_twitter" :value="old('social_twitter', $settings['social_twitter'])" placeholder="https://twitter.com/yourhandle" />
                                    <x-input-error :messages="$errors->get('social_twitter')" class="mt-2" />
                                </div>

                                <!-- Instagram -->
                                <div class="mb-4">
                                    <x-input-label for="social_instagram" :value="__('Instagram URL')" />
                                    <x-text-input id="social_instagram" class="block mt-1 w-full" type="url" name="social_instagram" :value="old('social_instagram', $settings['social_instagram'])" placeholder="https://instagram.com/yourhandle" />
                                    <x-input-error :messages="$errors->get('social_instagram')" class="mt-2" />
                                </div>

                                <!-- LinkedIn -->
                                <div class="mb-4">
                                    <x-input-label for="social_linkedin" :value="__('LinkedIn URL')" />
                                    <x-text-input id="social_linkedin" class="block mt-1 w-full" type="url" name="social_linkedin" :value="old('social_linkedin', $settings['social_linkedin'])" placeholder="https://linkedin.com/company/yourcompany" />
                                    <x-input-error :messages="$errors->get('social_linkedin')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>