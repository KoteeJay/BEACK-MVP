<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::updateOrCreate(
            ['email' => 'admin@beackapp.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Beack@MVP!'),
                'user_type' => 'super_admin',
            ]
        );
    }
}
