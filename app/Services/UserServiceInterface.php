<?php

namespace App\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function login(array $credentials): bool;
    public function logout();
    public function getUser(): ?User;
}
