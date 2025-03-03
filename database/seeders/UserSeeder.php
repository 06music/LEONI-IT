<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin User
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'site_id' => null, // Super admin does not belong to a specific site
        ]);

        // Manager User
        User::create([
            'name' => 'Site Manager',
            'email' => 'manager@example.com',
            'username' => 'manager',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'site_id' => 1, // Example site ID
        ]);

        // Superior Hierarchique User
        User::create([
            'name' => 'Superior Hierarchique',
            'email' => 'superior@example.com',
            'username' => 'superior',
            'password' => Hash::make('password'),
            'role' => 'superior_hierarchique',
            'site_id' => 1, // Example site ID
        ]);

        // Employee User
        User::create([
            'name' => 'John Doe',
            'email' => 'employee@example.com',
            'username' => 'employee',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'site_id' => 1, // Example site ID
        ]);

        // Add more employees
        User::factory(10)->create([
            'role' => 'employee',
            'site_id' => 1, // Assigning employees to site 1
        ]);
    }
}
