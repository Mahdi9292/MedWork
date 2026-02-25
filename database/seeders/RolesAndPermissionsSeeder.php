<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $config = config('perm');

        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($config as $key => $value) {

            if ($key === 'roles') {
                continue;
            }

            foreach ($value as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create Roles
        |--------------------------------------------------------------------------
        */

        foreach ($config['roles'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        $manager = Role::findByName('manager');
        $user = Role::findByName('user');

        // Manager gets ALL permissions
        $manager->givePermissionTo(Permission::all());

        // User gets only view permissions
        $user->givePermissionTo([
            config('perm.invoice.view'),
            config('perm.service.view'),
            config('perm.medical.certificate.view'),
            config('perm.medical.certificate.view'),
            config('perm.medical.activity.view'),
        ]);
    }
}
