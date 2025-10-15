<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Make sure to import your User model

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Default Admin',
            'role' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'mobile' => '9999999999',
            'email_verified_at' => now(),
            'password' => Hash::make('admin@2025'), // encrypted password
            'original_password' => 'admin@2025',    // optional for record
            'address' => '123 Admin Street',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ]);
    }
}
