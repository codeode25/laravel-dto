<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(UserDTO $userDTO): User
    {
        // we have type safety using the dto which basically acts like a struct
        return User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'age' => $userDTO->age,
            'password' => Hash::make($userDTO->password),
        ]);
    }
}