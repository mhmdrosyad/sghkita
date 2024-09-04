<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
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

        // Buat Roles dan berikan Permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo('view dashboard');
        $roleAdmin->givePermissionTo('manage users');
        $roleAdmin->givePermissionTo('view accounting');
        $roleAdmin->givePermissionTo('import');
        $roleAdmin->givePermissionTo('edit transaction');

        $roleEditor = Role::create(['name' => 'fo']);
        $roleEditor->givePermissionTo('view dashboard');
    }
}
