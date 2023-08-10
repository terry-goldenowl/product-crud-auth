<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public $userService;
    public $roleService;
    public $permissionService;

    public function __construct(UserService $userService, RoleService $roleService, PermissionService $permissionService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index(UsersDataTable $dataTable): View
    {
        return $dataTable->render('users.index');
    }

    public function indexRoles(): View
    {
        $users = $this->userService->getUsers()->get();
        $roles = $this->roleService->getRoles();
        $permissions = $this->permissionService->getPermissions();

        return view('users.users-roles', ['users' => $users, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function assignRoles(Request $request, int $userId): RedirectResponse
    {
        if (isset($request->roles)) {
            $roles = [];
            foreach ($request->roles as $roleId) {
                $role = $this->roleService->getRole($roleId);
                array_push($roles, $role);
            }

            // Remove all roles before assign new roles
            $this->userService->removeRoles($userId);
            $this->userService->assignRole($userId, $roles);
            return back()->with('success', "Assign roles successfully!");
        } else {
            return back()->withErrors(['error' => 'Please choose at least one role!']);
        }
    }

    public function givePermissions(Request $request, int $userId): RedirectResponse
    {
        if (isset($request->permissions)) {
            $permissions = [];
            foreach ($request->permissions as $permissionId) {
                $permission = $this->permissionService->getPermission($permissionId);
                array_push($permissions, $permission);
            }

            // Remove all permissions before assign new permissions
            $this->userService->removePermissions($userId);
            $this->userService->givePermissions($userId, $permissions);
            return back()->with('success', "Assign permissions successfully!");
        } else {
            return back()->withErrors(['error' => 'Please choose at least one permission!']);
        }
    }

    public function deleteUser(Request $request, int $userId): RedirectResponse
    {
        $isDeleted = $this->userService->deleteUser($userId);
        if ($isDeleted) {
            return back()->with('success', 'User deleted successfully!');
        }
        return back()->withErrors(['error' => 'Fail to delete user or user not found!']);
    }
}
