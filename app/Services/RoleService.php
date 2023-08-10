<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function createRole(string $role): Role
    {
        try {
            if (!Role::where('name', $role)->exists()) {
                return Role::create(['name' => $role]);
            }
            return null;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function getRoles()
    {
        try {
            return Role::all();
        } catch (\Throwable $th) {
            //throw $th;
            return [];
        }
    }

    public function addPermissionToRole(int $roleId, int $permissionId): void
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($permissionId);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function getRole(int $roleId): Role
    {
        try {
            return Role::findById($roleId);
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function deleteRole(int $roleId)
    {
        try {
            // Remove all permission assigned to role
            $role = Role::findById($roleId);
            $role->syncPermissions([]);

            // Destroy role
            return Role::destroy([$roleId]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
