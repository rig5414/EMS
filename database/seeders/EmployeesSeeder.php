<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [
            ['name' => 'John Ochieng', 'email' => 'john.ochieng@ems.local', 'department' => 'HR'],
            ['name' => 'Mary Kipchoge', 'email' => 'mary.kipchoge@ems.local', 'department' => 'FINANCE'],
            ['name' => 'James Mwangi', 'email' => 'james.mwangi@ems.local', 'department' => 'HSE'],
            ['name' => 'Sarah Kariuki', 'email' => 'sarah.kariuki@ems.local', 'department' => 'TRANSPORT'],
            ['name' => 'Peter Nyambura', 'email' => 'peter.nyambura@ems.local', 'department' => 'ICT'],
        ];

        foreach ($users as $idx => $u) {
            // Upsert user using Eloquent so we don't create duplicates
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make('password')]
            );

            // Upsert employee
            $position = match($u['department']) {
                'HR' => 'HR Manager',
                'FINANCE' => 'Finance Officer',
                'HSE' => 'HSE Manager',
                'TRANSPORT' => 'Transport Coordinator',
                'ICT' => 'IT Manager',
                default => 'Staff',
            };

            $employee = Employee::updateOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'position' => $position, 'salary' => 0]
            );

            // Attach to department
            $dept = Department::where('name', $u['department'])->first();
            if ($dept) {
                $employee->departments()->syncWithoutDetaching([$dept->id]);

                if ($idx === 0) {
                    // set HOD if not set
                    if (! $dept->hod_id) {
                        $dept->hod_id = $employee->id;
                        $dept->save();
                    }
                }
            }
        }
    }
}
