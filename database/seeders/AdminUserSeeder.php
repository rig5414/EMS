<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $email = 'admin@admin.com';
        $exists = DB::table('users')->where('email', $email)->exists();
        if (! $exists) {
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => $email,
                'password' => Hash::make('admin'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
