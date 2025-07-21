<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        UserProfile::create([
            'user_id' => $admin->id,
            'address' => 'Jl. Admin No. 1',
            'city' => 'Yogyakarta',
            'province' => 'DI Yogyakarta',
            'postal_code' => '55281',
            'bio' => 'Administrator of the system',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
        ]);

        // Create HRD User
        $hrd = User::create([
            'name' => 'HRD User',
            'email' => 'hrd@example.com',
            'password' => Hash::make('password'),
            'role' => 'hrd',
            'email_verified_at' => now(),
        ]);
        
        UserProfile::create([
            'user_id' => $hrd->id,
            'address' => 'Jl. HRD No. 1',
            'city' => 'Yogyakarta',
            'province' => 'DI Yogyakarta',
            'postal_code' => '55281',
            'bio' => 'HRD staff responsible for recruitment',
            'date_of_birth' => '1992-05-15',
            'gender' => 'female',
        ]);

        // Create Applicant User
        $applicant = User::create([
            'name' => 'Applicant User',
            'email' => 'applicant@example.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'email_verified_at' => now(),
        ]);
        
        UserProfile::create([
            'user_id' => $applicant->id,
            'address' => 'Jl. Applicant No. 1',
            'city' => 'Yogyakarta',
            'province' => 'DI Yogyakarta',
            'postal_code' => '55281',
            'bio' => 'Job seeker with experience in web development',
            'date_of_birth' => '1995-10-20',
            'gender' => 'male',
        ]);
        
        // Create more random applicants
        User::factory(10)
            ->state(['role' => 'applicant'])
            ->has(UserProfile::factory())
            ->create();
    }
}