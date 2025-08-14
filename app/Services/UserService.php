<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        // No type safety — we assume $data has 'name', 'email', 'age' etc.
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'age' => $data['age'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
    }
}