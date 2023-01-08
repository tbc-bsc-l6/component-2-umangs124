<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function addUser($user);
    public function getUserById($id);
    public function updateUser($userId, $formFields);
    public function updatePassword($userId, $formFields);
    public function updateVerificationCode($userId, $formFields);
    public function deleteUser($userId);
    public function getVerificationToken($id);
}