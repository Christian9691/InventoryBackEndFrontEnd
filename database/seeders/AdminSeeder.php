<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $username = env('ADMIN_USERNAME', 'admin');
        $password = env('ADMIN_PASSWORD');

        if (!$password) {
            return;
        }

        $exists = DB::table('users')->where('UserName', $username)->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'UserName' => $username,
                'Password' => Hash::make($password),
                'Role'     => 'Admin',
            ]);
        }
    }
}