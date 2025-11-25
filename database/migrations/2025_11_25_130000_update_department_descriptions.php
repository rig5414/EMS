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
            'HR' => 'Responsible for recruitment, employee relations, payroll support, training and development, and ensuring a positive workplace culture.',
            'FINANCE' => 'Handles budgeting, accounting, financial reporting, payroll processing, and compliance with financial regulations.',
            'HSE' => 'Oversees health, safety, and environmental programs ensuring workplace safety, incident reporting, and regulatory compliance.',
            'TRANSPORT' => 'Manages company fleet operations, logistics coordination, vehicle maintenance, and transport scheduling.',
            'ICT' => 'Provides information and communication technology support, network administration, and application maintenance.',
        ];

        foreach ($updates as $name => $description) {
            DB::table('departments')->where('name', $name)->update([
                'description' => $description,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert descriptions to NULL for these departments
        DB::table('departments')->whereIn('name', ['HR','FINANCE','HSE','TRANSPORT','ICT'])->update([
            'description' => null,
            'updated_at' => now(),
        ]);
    }
};
