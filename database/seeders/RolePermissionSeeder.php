<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);

        $permissions = [
            'clients.view',
            'clients.create',
            'clients.edit',
            'clients.delete',
            'services.manage',
            'payments.record',
            'payments.delete',
            'credentials.view',
            'credentials.edit',
            'reports.view',
            'finance.view',
            'finance.manage',
            'users.manage',
            'roles.manage',
            'clients.profile.view',
        ];

        foreach ($permissions as $perm) {
            Permission::create([
                'name' => $perm,
                'module' => explode('.', $perm)[0]
            ]);
        }

        $admin->permissions()->sync(Permission::all()->pluck('id'));
    }
}
