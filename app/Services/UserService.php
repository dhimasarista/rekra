<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(){}

    public function login(array $credentials): bool {
        return Auth::attempt($credentials);
    }

    public function getUser(): ?User
    {
        return Auth::user();
    }
}
