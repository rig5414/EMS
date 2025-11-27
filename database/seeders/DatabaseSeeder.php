<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Seed canonical departments first
        $this->call(DepartmentsSeeder::class);

        // Seed employees and attach to departments
        $this->call(EmployeesSeeder::class);

        // Seed admin user
        $this->call(AdminUserSeeder::class);
    }
}
