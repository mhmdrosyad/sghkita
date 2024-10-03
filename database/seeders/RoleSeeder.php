<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permission sidebar
        Permission::create(['name' => 'view transaction']);
        Permission::create(['name' => 'view accounting']);
        Permission::create(['name' => 'view reservation']);
        Permission::create(['name' => 'view kasbon']);
        Permission::create(['name' => 'view manage user']);

        // Permission transaction
        Permission::create(['name' => 'import transaction']);
        Permission::create(['name' => 'add fo transaction']);
        Permission::create(['name' => 'add bank transaction']);
        Permission::create(['name' => 'edit transaction']);

        // Other permission
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'manage user']);
        Permission::create(['name' => 'manage role']);
        Permission::create(['name' => 'manage permission']);
        Permission::create(['name' => 'add kasbon']);
        Permission::create(['name' => 'manage kasbon']);

        // Role admin
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(['view manage user', 'add user', 'manage user', 'manage role', 'manage permission']);

        // Other role
        Role::create(['name' => 'accounting']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'fo']);
        Role::create(['name' => 'owner']);
    }
}
