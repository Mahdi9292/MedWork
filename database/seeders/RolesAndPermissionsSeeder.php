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

        $permissions = collect($config)
            ->except('roles')
            ->flatten(2)   // flatten nested arrays
            ->values();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
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
            config('perm.finance.invoice.view'),
            config('perm.finance.service.view'),
            config('perm.medical.certificate.view'),
            config('perm.medical.activity.view'),
            config('perm.medical.employer.view'),
            config('perm.medical.employee.view'),
            config('perm.medical.comment.view'),
            config('perm.medical.prevention.view'),
            config('perm.medical.preventionType.view'),
        ]);
    }
}
