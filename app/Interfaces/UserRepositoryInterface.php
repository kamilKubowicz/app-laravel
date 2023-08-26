<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @return User
     * @param array<string, string> $attributes
     */
    public function create(array $attributes): User;
}
