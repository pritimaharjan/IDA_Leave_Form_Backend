<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example users
        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'password' => Hash::make('password123'),
            'employee_id' => 'EMP001',
            'phone_number' => '9800000001',
            'designation' => 'Software Engineer',
            'department_id' => 1, // Make sure this department exists in departments table
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'password' => Hash::make('password123'),
            'employee_id' => 'EMP002',
            'phone_number' => '9800000002',
            'designation' => 'Project Manager',
            'department_id' => 2,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Charlie Davis',
            'email' => 'charlie@example.com',
            'password' => Hash::make('password123'),
            'employee_id' => 'EMP003',
            'phone_number' => '9800000003',
            'designation' => 'Designer',
            'department_id' => 3,
            'status' => 'active',
        ]);
    }
}
