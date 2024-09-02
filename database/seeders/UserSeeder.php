<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234')
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Testing',
            'username' => 'testing',
            'email' => 'testing@example.com',
            'password' => Hash::make('testing1234')
        ]);

        $user->assignRole('editor');
    }
}
