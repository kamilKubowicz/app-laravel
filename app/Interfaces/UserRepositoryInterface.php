<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getUserByMail(string $email): ?User;
    public function getUserById(int $id): ?User;

    public function getAll(): Collection;
}
