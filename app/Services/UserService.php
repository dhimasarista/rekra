<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    public $user;
    /**
     * Create a new class instance.
     */
    public function __construct(){
        $this->user = User::class;
    }

    public function login(array $credentials): bool {
        return Auth::attempt($credentials);
    }

    public function findUseAuth(): ?User
    {
        return Auth::user();
    }

    public function logout(){
        return Auth::logout();
    }
    public function findAll(){
        return User::all();
    }
    public function findByLevel(array $levels): Collection{
        $users = User::whereIn('level', $levels)->get();
        return $users;
    }
    public function findById(string $id): ?User{
        return User::find($id);
    }
    public function createUser(array $data){
        $user = User::create($data);
        return '😊User baru dibuat';
    }
    public function updateUser(string $id, array $data){
        $user = $this->findById($id);
        $user->update($data);
        return "😊User diperbarui";
    }
    public function deleteUser(string $id)
    {
        $user = $this->findById($id);
        $user->delete();
        return 'User berhasil dihapus';
    }
}
