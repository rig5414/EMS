<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $departments = [
            ['name' => 'HR', 'description' => 'Human Resources'],
            ['name' => 'FINANCE', 'description' => 'Finance Department'],
            ['name' => 'HSE', 'description' => 'Health, Safety & Environment'],
            ['name' => 'TRANSPORT', 'description' => 'Transport & Logistics'],
            ['name' => 'ICT', 'description' => 'Information and Communication Technology'],
        ];

        foreach ($departments as $d) {
            DB::table('departments')->updateOrInsert(
                ['name' => $d['name']],
                ['description' => $d['description'], 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
