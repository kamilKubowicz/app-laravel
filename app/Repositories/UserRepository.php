<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return User
     * @param array<string,string> $attributes
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }
}
