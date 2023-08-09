<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function indexRoles()
    {
        $users = UserService::getUsers()->get();
        $roles = RoleService::getRoles();

        return view('users.users-roles', ['users' => $users, 'roles' => $roles]);
    }

    public function assignRoles(Request $request, $userId)
    {
        // dd($request->all());
        if (isset($request->roles)) {
            $roles = [];
            foreach ($request->roles as $roleId) {
                $role = RoleService::getRole($roleId);
                array_push($roles, $role);
            }

            // Remove all roles before assign new roles
            UserService::removeRoles($userId);
            UserService::assignRole($userId, $roles);
            return back()->with('success', "Assign roles successfully!");
        } else {
            return back()->withErrors(['error' => 'Please choose at least one role!']);
        }
    }

    public function deleteUser(Request $request, $userId)
    {
        $isDeleted = UserService::deleteUser($userId);
        if ($isDeleted) {
            return back()->with('success', 'User deleted successfully!');
        }
        return back()->withErrors(['error' => 'Fail to delete user or user not found!']);
    }
}
