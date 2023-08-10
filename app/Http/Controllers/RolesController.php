<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public $roleService;
    public $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function createRole(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['string', 'required', Rule::unique('roles')]]);
        $newRole = $this->roleService->createRole(strtolower($request->name));

        if ($newRole) {
            return back()->with('success', "Role $newRole->name is created!");
        } else {
            return back()->withErrors(['error' => 'Something went wrong or role has already been created!']);
        }
    }

    public function getRoles(): View
    {
        $roles = $this->roleService->getRoles();
        $permissions = $this->permissionService->getPermissions();
        return view('users.roles-index', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function addPermissionsToRole(Request $request, int $roleId): RedirectResponse
    {
        // dd($roleId);
        if (isset($request->permissions)) {
            foreach ($request->permissions as $permissionId) {
                $this->roleService->addPermissionToRole($roleId, $permissionId);
            }
            return back()->with('success', "Add permissions successfully!");
        } else {
            return back()->withErrors(['error' => 'Please choose at least one permission!']);
        }
    }

    public function deleteRole(Request $request, int $roleId): RedirectResponse
    {
        $isDeleted = $this->roleService->deleteRole($roleId);

        if ($isDeleted) {
            return back()->with('success', 'Delete role successfully!');
        } else {
            return back()->withErrors(['error' => 'Fail to delete role!']);
        }
    }
}
