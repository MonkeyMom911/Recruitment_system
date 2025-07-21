<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SettingController extends Controller
{
    public function index()
    {
        // Get all settings from the database
        $settingsCollection = Setting::all()->pluck('value', 'key');
        
        $settings = [
            'site_name' => $settingsCollection->get('site_name', config('app.name')),
            'site_description' => $settingsCollection->get('site_description', 'Employee Recruitment System'),
            'contact_email' => $settingsCollection->get('contact_email', 'info@example.com'),
            'contact_phone' => $settingsCollection->get('contact_phone', '+1234567890'),
            'company_address' => $settingsCollection->get('company_address', ''),
            'logo' => $settingsCollection->get('logo', ''),
            'social_facebook' => $settingsCollection->get('social_facebook', ''),
            'social_twitter' => $settingsCollection->get('social_twitter', ''),
            'social_instagram' => $settingsCollection->get('social_instagram', ''),
            'social_linkedin' => $settingsCollection->get('social_linkedin', ''),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_linkedin' => 'nullable|url',
        ]);
        
        // Update settings
        $this->updateSetting('site_name', $request->site_name);
        $this->updateSetting('site_description', $request->site_description);
        $this->updateSetting('contact_email', $request->contact_email);
        $this->updateSetting('contact_phone', $request->contact_phone);
        $this->updateSetting('company_address', $request->company_address);
        $this->updateSetting('social_facebook', $request->social_facebook);
        $this->updateSetting('social_twitter', $request->social_twitter);
        $this->updateSetting('social_instagram', $request->social_instagram);
        $this->updateSetting('social_linkedin', $request->social_linkedin);
        
        // Update app name
        if (config('app.name') !== $request->site_name) {
            // Update .env file
            $this->updateEnv(['APP_NAME' => $request->site_name]);
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Hapus logo lama dari Cloudinary jika ada
            $oldLogoSetting = Setting::where('key', 'logo')->first();
            if ($oldLogoSetting && $oldLogoSetting->value) {
                // Ekstrak public_id dari URL
                 $url = $oldLogoSetting->value;
                preg_match('/\/upload\/(?:v\d+\/)?([^\.]+)/', $url, $matches);
                if (isset($matches[1])) {
                    $publicId = $matches[1];
                    // **PERBAIKAN:** Gunakan uploadApi()->destroy() untuk menghapus file
                    Cloudinary::uploadApi()->destroy($publicId);
                }
            }

            // Unggah logo baru ke Cloudinary dalam folder 'logos'
           $result = Cloudinary::uploadApi()->upload($request->file('logo')->getRealPath(), [
                'folder' => 'logos'
            ]);
            
            // Dapatkan URL aman dari hasil array
            $path = $result['secure_url'];
            
            $this->updateSetting('logo', $path);

        }
        
        return back()->with('success', 'Settings updated successfully.');
    }
    
    private function updateSetting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    
    private function updateEnv($data)
    {
        $envFile = app()->environmentFilePath();
        $envContents = file_get_contents($envFile);
        
        foreach ($data as $key => $value) {
            // Wrap value in quotes if it contains spaces
            $value = strpos($value, ' ') !== false ? '"'.$value.'"' : $value;
            
            // Replace existing variables
            $envContents = preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$value}",
                $envContents
            );
        }
        
        file_put_contents($envFile, $envContents);
    }
}