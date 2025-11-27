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

    /**
        // Structural seeders moved here (departments, employees, admin)
        $this->call(DepartmentsSeeder::class);
        $this->call(EmployeesSeeder::class);
        $this->call(AdminUserSeeder::class);
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create 10 employees
        $employees = Employee::factory(10)->create();

        // Create 5 departments
        $departments = Department::factory(5)->create();

        // Assign some employees as HODs
        $departments[0]->update(['hod_id' => $employees[0]->id]);
        $departments[1]->update(['hod_id' => $employees[1]->id]);
        $departments[2]->update(['hod_id' => $employees[2]->id]);

        // Assign employees to departments
        foreach ($employees as $employee) {
            $randomDepts = $departments->random(rand(1, 3))->pluck('id');
            $employee->departments()->attach($randomDepts);
        }
    }
}
