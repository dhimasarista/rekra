<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function login(array $credentials): bool;
    public function logout();
    public function findUseAuth(): ?User;
    public function findAll();
    public function findById(string $id): ?User;
    public function findByLevel(array $levels): Collection;
    public function createUser(array $data);
    public function updateUser(string $id, array $data);
    public function deleteUser(string $id);
}
