<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getUserByMail(string $email): ?User
    {
       return User::where('email', $email)
            ->first();
    }

    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    public function getAll(): Collection
    {
        return User::all();
    }
}
