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
        $targets = ['HR', 'FINANCE', 'HSE', 'TRANSPORT', 'ICT'];

        DB::transaction(function () use ($targets) {
            // Remove any duplicate rows that already have the target names but may cause conflicts
            DB::table('departments')->whereIn('name', $targets)->delete();

            $existing = DB::table('departments')->orderBy('id')->get();

            $countExisting = $existing->count();
            $countTarget = count($targets);

            // Update existing rows to match target names (by order)
            for ($i = 0; $i < min($countExisting, $countTarget); $i++) {
                DB::table('departments')->where('id', $existing[$i]->id)->update([
                    'name' => $targets[$i],
                    'updated_at' => now(),
                ]);
            }

            // If there are fewer existing rows than targets, insert the remaining
            if ($countExisting < $countTarget) {
                $toInsert = [];
                for ($i = $countExisting; $i < $countTarget; $i++) {
                    $toInsert[] = ['name' => $targets[$i], 'created_at' => now(), 'updated_at' => now()];
                }
                DB::table('departments')->insert($toInsert);
            }

            // If there are more existing rows than targets, delete the extras
            if ($countExisting > $countTarget) {
                $extraIds = $existing->slice($countTarget)->pluck('id')->all();
                DB::table('departments')->whereIn('id', $extraIds)->delete();
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
        // Can't reliably restore previous dummy values; leave empty.
    }
};
