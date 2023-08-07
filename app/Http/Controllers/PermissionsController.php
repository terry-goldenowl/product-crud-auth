<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{

    public function getPermissions()
    {
        $permissions = PermissionService::getPermissions();
        $roles = RoleService::getRoles();

        return view('users.permissions-index', ['permissions' => $permissions, 'roles' => $roles]);
    }

    public function createPermission(Request $request)
    {
        $request->validate(['name' => ['string', 'required', Rule::unique('roles')]]);
        $newPermission = PermissionService::createPermission(strtolower($request->name));

        if ($newPermission) {
            return back()->with('success', "Permission $newPermission->name is created!");
        } else {
            return back()->withErrors(['error' => 'Something went wrong or permission has already been created!']);
        }
    }

    public function deletePermission(Request $request, $permissionId)
    {
        $isDeleted = PermissionService::deletePermission($permissionId);

        if ($isDeleted) {
            return back()->with('success', 'Delete permission successfully!');
        } else {
            return back()->withErrors(['error' => 'Fail to delete permission!']);
        }
    }
}
