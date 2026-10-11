<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\Roles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'Create an admin account';

    public function handle(): int
    {
        $username = trim((string) $this->ask('Admin username'));

        if ($username === '') {
            $this->error('Username cannot be empty.');
            return self::FAILURE;
        }

        $password = $this->secret('Admin password (minimum 12 characters)');

        if (! is_string($password) || strlen($password) < 12) {
            $this->error('Password must be at least 12 characters.');
            return self::FAILURE;
        }

        $user = User::whereRaw(
            'LOWER(UserName) = ?',
            [mb_strtolower($username)]
        )->first();

        if ($user) {
            $this->error('That username already exists.');
            return self::FAILURE;
        }

        User::create([
            'UserName' => $username,
            'Password' => Hash::make($password),
            'Role' => Roles::ADMIN,
        ]);

        $this->info('Admin account created successfully.');

        return self::SUCCESS;
    }
}