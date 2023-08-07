<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public static function createRole(string $role)
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

    public static function getRoles()
    {
        try {
            return Role::all();
        } catch (\Throwable $th) {
            //throw $th;
            return [];
        }
    }

    public static function addPermissionToRole(int $roleId, int $permissionId)
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($permissionId);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public static function getRole(int $roleId)
    {
        try {
            return Role::findById($roleId);
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public static function deleteRole(int $roleId)
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
