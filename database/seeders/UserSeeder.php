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

        $rully = User::create([
            'name' => 'Rully',
            'username' => 'rully',
            'email' => 'rully@example.com',
            'password' => Hash::make('rully1234')
        ]);

        $admin->assignRole('admin');
        $rully->assignRole('accounting');

        $etik = User::create([
            'name' => 'Etik Nurul',
            'username' => 'etik',
            'email' => 'etik@example.com',
            'password' => Hash::make('etik1234')
        ]);

        $angger = User::create([
            'name' => 'Angger Mukti Ali',
            'username' => 'angger',
            'email' => 'angger@example.com',
            'password' => Hash::make('angger1234')
        ]);

        $romi = User::create([
            'name' => 'Romi',
            'username' => 'romi',
            'email' => 'romi@example.com',
            'password' => Hash::make('romi1234')
        ]);

        $testing = User::create([
            'name' => 'testing',
            'username' => 'testing',
            'email' => 'testing@example.com',
            'password' => Hash::make('testing1234')
        ]);

        $manager = User::create([
            'name' => 'Manager',
            'username' => 'manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('manager1234')
        ]);

        $etik->assignRole('fo');
        $angger->assignRole('fo');
        $romi->assignRole('fo');
        $testing->assignRole('fo');
        $manager->assignRole('manager');

        $owner = User::create([
            'name' => 'Owner',
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('owner1234')
        ]);
        $owner->assignRole('owner');
    }
}
