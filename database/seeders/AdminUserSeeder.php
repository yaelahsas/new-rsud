<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@rsudgenteng.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $this->command->info('Default admin user created successfully.');
        $this->command->info('Email: admin@rsudgenteng.com');
        $this->command->info('Password: admin123');
    }
}