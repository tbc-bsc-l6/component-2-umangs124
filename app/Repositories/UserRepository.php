<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::query('users')->where('role_id', '=', 1)->filter(request(['user_search']))->paginate(8);
    }

    // public function getRoleIdWithIdOne()
    // {
    //     return DB::table('roles')->select('id')->where('id', '=', 1)->get();
    // }
    public function addUser($user)
    {
        User::create($user);
    }
    public function getUserById($id)
    {
        return DB::table('users')->where('id', '=', $id)->first();
    }
    public function updateUser($userId, $formFields)
    {
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'name' => $formFields['name'],
                'email' => $formFields['email'],
                'updated_at' => Carbon::now()
            ]);
            
        if (count($formFields) == 3) {
            
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'image' => $formFields['image'],
                    'updated_at' => Carbon::now()
                ]);
        }
    }
    public function updatePassword($userId, $formFields)
    {
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'password' => $formFields['password'],
                'verification_token' => $formFields['verification_token'],
                'updated_at' => Carbon::now()
            ]);
    }
    public function updateVerificationCode($userId, $formFields)
    {
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'verification_token' => $formFields['verification_token'],
                'updated_at' => Carbon::now()
            ]);
    }
    public function deleteUser($userId)
    {
        DB::table('users')->where('id', $userId)->delete();
    }
    public function getVerificationToken($id)
    {
        return DB::table('users')->select('verification_token')
        ->where('id', '=', $id)->first();
    }
}
