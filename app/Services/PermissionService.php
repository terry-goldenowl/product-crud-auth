<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public static function createPermission(string $permission)
    {
        try {
            if (!Permission::where('name', $permission)->exists()) {
                return Permission::create(['name' => $permission]);
            }
            return null;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public static function getPermissions()
    {
        try {
            return Permission::all();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function deletePermission(int $permissionId)
    {
        try {
            // Destroy permission
            return Permission::destroy([$permissionId]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
