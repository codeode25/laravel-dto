<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{

    public function __construct(private readonly UserService $userService) {}

    public function store(Request $request)
    {
        // 1. Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'age' => 'nullable|integer|min:1',
            'password' => 'required|min:6',
        ]);

        // 2. Pass array to service
        $user = $this->userService->createUser(
            new UserDTO(
                name: $validated['name'],
                email: $validated['email'],
                password: $validated['password'],
                age: $validated['age'] ?? null,
            )
        );

        return response()->json($user, 201);
    }
}
