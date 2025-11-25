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

        $departments = [
            ['name' => 'HR', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'FINANCE', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'HSE', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'TRANSPORT', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ICT', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Use upsert so running the migration multiple times won't create duplicates
        DB::table('departments')->upsert($departments, ['name'], ['updated_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('departments')->whereIn('name', ['HR', 'FINANCE', 'HSE', 'TRANSPORT', 'ICT'])->delete();
    }
};
