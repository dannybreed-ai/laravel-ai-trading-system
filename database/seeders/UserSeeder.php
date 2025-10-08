<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'balance' => 10000.00,
            'status' => true,
            'is_admin' => true,
            'kyc_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Demo User',
            'email' => 'demo@stockandfi.com',
            'username' => 'demo',
            'password' => Hash::make('password'),
            'balance' => 1000.00,
            'status' => true,
            'is_admin' => false,
            'kyc_verified_at' => now(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@stockandfi.com',
            'username' => 'testuser',
            'password' => Hash::make('password'),
            'balance' => 500.00,
            'status' => true,
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}
