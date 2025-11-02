<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // php artisan db:seed
    public function run(): void
    {
        // Default admin account
        Account::create([
            'email' => 'admin@library.com',
            'password' => Hash::make('admin'), // hashed
            'role' => 'admin',
        ]);

        $userAccount = Account::create([
            'email' => 'user@library.com',
            'password' => Hash::make('user'), // hashed
            'role' => 'user',
        ]);
    }
}
