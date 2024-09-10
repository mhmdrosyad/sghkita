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

        // Buat Permissions
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view accounting']);
        Permission::create(['name' => 'import']);
        Permission::create(['name' => 'edit transaction']);
        Permission::create(['name' => 'editor']);
        Permission::create(['name' => 'view reservation']);

        // Buat Roles dan berikan Permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo('view dashboard');
        $roleAdmin->givePermissionTo('manage users');
        $roleAdmin->givePermissionTo('view accounting');
        $roleAdmin->givePermissionTo('import');
        $roleAdmin->givePermissionTo('edit transaction');
        $roleAdmin->givePermissionTo('editor');
        $roleAdmin->givePermissionTo('view reservation');

        $roleEditor = Role::create(['name' => 'fo']);
        $roleEditor->givePermissionTo('view dashboard');
        $roleEditor->givePermissionTo('editor');
        $roleEditor->givePermissionTo('view reservation');

        $roleManager = Role::create(['name' => 'manager']);
        $roleManager->givePermissionTo('view dashboard');
        $roleManager->givePermissionTo('view accounting');
        $roleManager->givePermissionTo('view reservation');

        $roleOwner = Role::create(['name' => 'owner']);
        $roleOwner->givePermissionTo('view dashboard');
        $roleOwner->givePermissionTo('view accounting');
    }
}
