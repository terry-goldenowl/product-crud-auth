<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function createRole(Request $request)
    {
        $request->validate(['name' => ['string', 'required', Rule::unique('roles')]]);
        $newRole = RoleService::createRole(strtolower($request->name));

        if ($newRole) {
            return back()->with('success', "Role $newRole->name is created!");
        } else {
            return back()->withErrors(['error' => 'Something went wrong or role has already been created!']);
        }
    }

    public function getRoles(): View
    {
        $roles = RoleService::getRoles();
        $permissions = PermissionService::getPermissions();
        return view('users.roles-index', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function addPermissionsToRole(Request $request, $roleId)
    {
        // dd($roleId);
        if (isset($request->permissions)) {
            foreach ($request->permissions as $permissionId) {
                RoleService::addPermissionToRole($roleId, $permissionId);
            }
            return back()->with('success', "Add permissions successfully!");
        } else {
            return back()->withErrors(['error' => 'Please choose at least one permission!']);
        }
    }

    public function deleteRole(Request $request, $roleId)
    {
        $isDeleted = RoleService::deleteRole($roleId);

        if ($isDeleted) {
            return back()->with('success', 'Delete role successfully!');
        } else {
            return back()->withErrors(['error' => 'Fail to delete role!']);
        }
    }
}
