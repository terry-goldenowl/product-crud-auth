<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use App\Services\PermissionServiceRedis;
use App\Services\RoleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    public $permissionService;
    public $roleService;

    public function __construct(PermissionService $permissionService, RoleService $roleService)
    {
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
    }

    public function getPermissions(): View
    {
        $permissions = $this->permissionService->getPermissions();
        $roles = $this->roleService->getRoles();

        return view('users.permissions-index', ['permissions' => $permissions, 'roles' => $roles]);
    }

    public function createPermission(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['string', 'required', Rule::unique('roles')]]);
        $newPermission = $this->permissionService->createPermission(strtolower($request->name));

        if ($newPermission) {
            return back()->with('success', "Permission $newPermission->name is created!");
        } else {
            return back()->withErrors(['error' => 'Something went wrong or permission has already been created!']);
        }
    }

    public function deletePermission(Request $request, int $permissionId): RedirectResponse
    {
        $isDeleted = $this->permissionService->deletePermission($permissionId);

        if ($isDeleted) {
            return back()->with('success', 'Delete permission successfully!');
        } else {
            return back()->withErrors(['error' => 'Fail to delete permission!']);
        }
    }
}
