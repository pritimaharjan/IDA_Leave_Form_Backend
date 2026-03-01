<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_types')->insert([
            ['name' => 'Annual Leave',        'is_paid' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sick Leave',          'is_paid' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Early Leave',         'is_paid' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Casual Leave',        'is_paid' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Work From Home',      'is_paid' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emergency Leave',     'is_paid' => true,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
