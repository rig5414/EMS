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

        $updates = [
            ['name' => 'John Ochieng', 'old_email' => 'john.ochieng@ems.local', 'new_email' => 'john.ochieng@bulkstream.com', 'salary' => 120000],
            ['name' => 'Mary Kipchoge', 'old_email' => 'mary.kipchoge@ems.local', 'new_email' => 'mary.kipchoge@bulkstream.com', 'salary' => 110000],
            ['name' => 'James Mwangi', 'old_email' => 'james.mwangi@ems.local', 'new_email' => 'james.mwangi@bulkstream.com', 'salary' => 95000],
            ['name' => 'Sarah Kariuki', 'old_email' => 'sarah.kariuki@ems.local', 'new_email' => 'sarah.kariuki@bulkstream.com', 'salary' => 85000],
            ['name' => 'Peter Nyambura', 'old_email' => 'peter.nyambura@ems.local', 'new_email' => 'peter.nyambura@bulkstream.com', 'salary' => 130000],
        ];

        foreach ($updates as $u) {
            // Try to find by name first, then by old email
            $employee = DB::table('employees')
                ->where('name', $u['name'])
                ->orWhere('email', $u['old_email'])
                ->first();

            if ($employee) {
                $updateData = [
                    'salary' => $u['salary'],
                    'updated_at' => $now,
                ];

                $emailInUse = DB::table('employees')
                    ->where('email', $u['new_email'])
                    ->where('id', '<>', $employee->id)
                    ->exists();

                if (! $emailInUse) {
                    $updateData['email'] = $u['new_email'];
                }

                DB::table('employees')->where('id', $employee->id)->update($updateData);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No-op: don't try to revert individual updates, let migrate:refresh handle full reset
    }
};
