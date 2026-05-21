<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['user_id' => 'A001-2026'],
            [
                'name'     => 'Dean Administrator',
                'email'    => 'admin@evsu.edu.ph',
                'user_id'  => 'soe',
                'password' => Hash::make('dean123'),
            ]
        );
    }
}