<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        // Update or create users with realistic data
        $users = [
            ['name' => 'John Ochieng', 'email' => 'john.ochieng@ems.local', 'department' => 'HR'],
            ['name' => 'Mary Kipchoge', 'email' => 'mary.kipchoge@ems.local', 'department' => 'FINANCE'],
            ['name' => 'James Mwangi', 'email' => 'james.mwangi@ems.local', 'department' => 'HSE'],
            ['name' => 'Sarah Kariuki', 'email' => 'sarah.kariuki@ems.local', 'department' => 'TRANSPORT'],
            ['name' => 'Peter Nyambura', 'email' => 'peter.nyambura@ems.local', 'department' => 'ICT'],
        ];

        DB::transaction(function () use ($users, $now) {
            // Clear existing users (except Breeze default if any)
            DB::table('users')->truncate();

            // Create users
            foreach ($users as $idx => $userData) {
                $user = DB::table('users')->insertGetId([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'), // Default password
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Create corresponding employee record and assign to department
                $department = DB::table('departments')->where('name', $userData['department'])->first();
                if ($department) {
                    $employeeId = DB::table('employees')->insertGetId([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'position' => match($userData['department']) {
                            'HR' => 'HR Manager',
                            'FINANCE' => 'Finance Officer',
                            'HSE' => 'HSE Manager',
                            'TRANSPORT' => 'Transport Coordinator',
                            'ICT' => 'IT Manager',
                        },
                        'salary' => 0, // Can be set later
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // Attach employee to department
                    DB::table('department_employee')->insert([
                        'employee_id' => $employeeId,
                        'department_id' => $department->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // Set the first user as HOD for their department
                    if ($idx === 0) {
                        DB::table('departments')->where('id', $department->id)->update(['hod_id' => $employeeId]);
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Clear the created users and employees
        DB::table('users')->truncate();
        DB::table('employees')->truncate();
        DB::table('department_employee')->truncate();
    }
};
