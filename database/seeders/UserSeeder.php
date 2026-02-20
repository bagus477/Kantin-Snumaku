<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pembeli@example.com'],
            [
                'name' => 'Pembeli Satu',
                'password' => 'password', // akan di-hash otomatis oleh cast di model
                'role' => 'pembeli',
            ]
        );

        User::updateOrCreate(
            ['email' => 'penjual@example.com'],
            [
                'name' => 'Penjual Satu',
                'password' => 'password',
                'role' => 'penjual',
            ]
        );
    }
}
