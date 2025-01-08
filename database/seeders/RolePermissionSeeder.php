<?php

namespace Database\Seeders;

use App\Enums\DefaultRolesEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = PermissionsEnum::cases();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission->value]);
        }

        // Create super admin role
        Role::create(['name' => DefaultRolesEnum::SUPER_ADMIN]);

        // Create default roles and assign permissions
        $role = Role::create(['name' => DefaultRolesEnum::ADMIN]);
        $role->givePermissionTo($permissions);
    }
}
