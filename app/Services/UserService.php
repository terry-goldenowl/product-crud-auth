<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function getUsers()
    {
        return User::where('active', 1);
    }

    public static function assignRole(int $userId, array $roles)
    {
        $user = User::findOrFail($userId);
        if ($user) {
            $user->assignRole($roles);
        }
    }

    public static function removeRoles(int $userId)
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

    public static function deleteUser(int $userId)
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
