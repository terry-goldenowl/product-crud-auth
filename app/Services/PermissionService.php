<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function createPermission(string $permission): Permission
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

    public function getPermissions()
    {
        try {
            return Permission::all();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deletePermission(int $permissionId): bool
    {
        try {
            // Destroy permission
            return Permission::destroy([$permissionId]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getPermission(int $permissionId): Permission
    {
        try {
            return Permission::findById($permissionId);
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }
}
