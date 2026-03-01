<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'IDA',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IDE',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'On Air',  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
