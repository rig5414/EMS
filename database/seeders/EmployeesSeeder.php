<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            // create user if not exists
            $userId = DB::table('users')->where('email', $u['email'])->value('id');
            if (! $userId) {
                $userId = DB::table('users')->insertGetId([
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'password' => Hash::make('password'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // create employee if not exists
            $employeeId = DB::table('employees')->where('email', $u['email'])->value('id');
            if (! $employeeId) {
                $position = match($u['department']) {
                    'HR' => 'HR Manager',
                    'FINANCE' => 'Finance Officer',
                    'HSE' => 'HSE Manager',
                    'TRANSPORT' => 'Transport Coordinator',
                    'ICT' => 'IT Manager',
                    default => 'Staff',
                };

                $employeeId = DB::table('employees')->insertGetId([
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'position' => $position,
                    'salary' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // attach to department
            $deptId = DB::table('departments')->where('name', $u['department'])->value('id');
            if ($deptId) {
                $exists = DB::table('department_employee')->where('employee_id', $employeeId)->where('department_id', $deptId)->exists();
                if (! $exists) {
                    DB::table('department_employee')->insert(['employee_id' => $employeeId, 'department_id' => $deptId, 'created_at' => $now, 'updated_at' => $now]);
                }

                if ($idx === 0) {
                    DB::table('departments')->where('id', $deptId)->update(['hod_id' => $employeeId]);
                }
            }
        }
    }
}
