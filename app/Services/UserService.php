<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUsers()
    {
        return User::where('active', 1);
    }

    public function assignRole(int $userId, array $roles): void
    {
        $user = User::findOrFail($userId);
        if ($user) {
            $user->assignRole($roles);
        }
    }

    public function removeRoles(int $userId): void
    {
        try {
            $user = User::findOrFail($userId);
            if ($user) {
                $user->syncRoles([]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function givePermissions(int $userId, array $permissions): void
    {
        $user = User::findOrFail($userId);
        if ($user) {
            $user->syncPermissions($permissions);
        }
    }

    public function removePermissions(int $userId): void
    {
        try {
            $user = User::findOrFail($userId);
            if ($user) {
                $user->syncPermissions([]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteUser(int $userId): bool
    {
        try {
            $user =  User::find($userId);
            if ($user) {
                return $user->update(['active' => false]);
            }
            return 0;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
