<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@stockandfi.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@stockandfi.com',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'balance' => 10000.00,
                'status' => true,
                'is_admin' => true,
                'kyc_verified_at' => now(),
            ]);
        }

        // Check if demo user already exists
        if (!User::where('email', 'demo@stockandfi.com')->exists()) {
            User::create([
                'name' => 'Demo User',
                'email' => 'demo@stockandfi.com',
                'username' => 'demo',
                'password' => Hash::make('password'),
                'balance' => 5000.00,
                'status' => true,
                'is_admin' => false,
                'kyc_verified_at' => now(),
            ]);
        }

        // Check if test user already exists
        if (!User::where('email', 'test@stockandfi.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@stockandfi.com',
                'username' => 'test',
                'password' => Hash::make('password'),
                'balance' => 2500.00,
                'status' => true,
                'is_admin' => false,
            ]);
        }
    }
}
