<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param array<string, string> $attributes
     */
    public function create(array $attributes): User;

    public function getUserByMail(string $email): ?User;
}
