<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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

        $employees = [
            // existing (ensure salaries updated)
            ['name' => 'John Ochieng', 'email' => 'john.ochieng@bulkstream.com', 'position' => 'HR Manager', 'salary' => 120000, 'department' => 'HR'],
            ['name' => 'Mary Kipchoge', 'email' => 'mary.kipchoge@bulkstream.com', 'position' => 'Finance Officer', 'salary' => 110000, 'department' => 'FINANCE'],
            ['name' => 'James Mwangi', 'email' => 'james.mwangi@bulkstream.com', 'position' => 'HSE Manager', 'salary' => 95000, 'department' => 'HSE'],
            ['name' => 'Sarah Kariuki', 'email' => 'sarah.kariuki@bulkstream.com', 'position' => 'Transport Coordinator', 'salary' => 85000, 'department' => 'TRANSPORT'],
            ['name' => 'Peter Nyambura', 'email' => 'peter.nyambura@bulkstream.com', 'position' => 'IT Manager', 'salary' => 130000, 'department' => 'ICT'],

            // new users
            ['name' => 'Alice Njoroge', 'email' => 'alice.njoroge@bulkstream.com', 'position' => 'HR Officer', 'salary' => 70000, 'department' => 'HR'],
            ['name' => 'Robert Otieno', 'email' => 'robert.otieno@bulkstream.com', 'position' => 'Recruiter', 'salary' => 65000, 'department' => 'HR'],
            ['name' => 'Grace Wanjiru', 'email' => 'grace.wanjiru@bulkstream.com', 'position' => 'Accountant', 'salary' => 90000, 'department' => 'FINANCE'],
            ['name' => 'David Kamau', 'email' => 'david.kamau@bulkstream.com', 'position' => 'Finance Analyst', 'salary' => 85000, 'department' => 'FINANCE'],
            ['name' => 'Esther Achieng', 'email' => 'esther.achieng@bulkstream.com', 'position' => 'Safety Officer', 'salary' => 60000, 'department' => 'HSE'],
            ['name' => 'Michael Odhiambo', 'email' => 'michael.odhiambo@bulkstream.com', 'position' => 'Safety Technician', 'salary' => 58000, 'department' => 'HSE'],
            ['name' => 'Kevin Mwangi', 'email' => 'kevin.mwangi@bulkstream.com', 'position' => 'Fleet Supervisor', 'salary' => 75000, 'department' => 'TRANSPORT'],
            ['name' => 'Linda Karanja', 'email' => 'linda.karanja@bulkstream.com', 'position' => 'Driver', 'salary' => 50000, 'department' => 'TRANSPORT'],
            ['name' => 'Samuel Mutua', 'email' => 'samuel.mutua@bulkstream.com', 'position' => 'Systems Administrator', 'salary' => 95000, 'department' => 'ICT'],
            ['name' => 'Fiona Njeri', 'email' => 'fiona.njeri@bulkstream.com', 'position' => 'Support Engineer', 'salary' => 65000, 'department' => 'ICT'],
        ];

        DB::transaction(function () use ($employees, $now) {
            foreach ($employees as $emp) {
                $existing = DB::table('employees')->where('email', $emp['email'])->first();

                if ($existing) {
                    DB::table('employees')->where('id', $existing->id)->update([
                        'name' => $emp['name'],
                        'position' => $emp['position'],
                        'salary' => $emp['salary'],
                        'updated_at' => $now,
                    ]);
                    $employeeId = $existing->id;
                } else {
                    $employeeId = DB::table('employees')->insertGetId([
                        'name' => $emp['name'],
                        'email' => $emp['email'],
                        'position' => $emp['position'],
                        'salary' => $emp['salary'],
                        'status' => 'active',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                // Attach to department if exists
                $department = DB::table('departments')->where('name', $emp['department'])->first();
                if ($department) {
                    $existsPivot = DB::table('department_employee')
                        ->where('employee_id', $employeeId)
                        ->where('department_id', $department->id)
                        ->exists();

                    if (! $existsPivot) {
                        DB::table('department_employee')->insert([
                            'employee_id' => $employeeId,
                            'department_id' => $department->id,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
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
        $emails = [
            'alice.njoroge@bulkstream.com','robert.otieno@bulkstream.com','grace.wanjiru@bulkstream.com','david.kamau@bulkstream.com',
            'esther.achieng@bulkstream.com','michael.odhiambo@bulkstream.com','kevin.mwangi@bulkstream.com','linda.karanja@bulkstream.com',
            'samuel.mutua@bulkstream.com','fiona.njeri@bulkstream.com'
        ];

        DB::transaction(function () use ($emails) {
            $employeeIds = DB::table('employees')->whereIn('email', $emails)->pluck('id')->all();
            if (!empty($employeeIds)) {
                DB::table('department_employee')->whereIn('employee_id', $employeeIds)->delete();
                DB::table('employees')->whereIn('id', $employeeIds)->delete();
            }
        });
    }
};
