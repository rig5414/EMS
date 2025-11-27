<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('employees', function (Blueprint $table) {
            if (! Schema::hasColumn('employees', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('departments', function (Blueprint $table) {
            if (! Schema::hasColumn('departments', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Optional: pivot soft deletes (if you want to soft-delete relations)
        Schema::table('department_employee', function (Blueprint $table) {
            if (! Schema::hasColumn('department_employee', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('department_employee', function (Blueprint $table) {
            if (Schema::hasColumn('department_employee', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });

        Schema::table('departments', function (Blueprint $table) {
            if (Schema::hasColumn('departments', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
