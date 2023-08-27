<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function deleteUser(int $id): void
    {
        $user = $this->getUser($id);
        $user->delete();
    }

    /**
     * @param array<string, string> $attributes
     */
    public function editUser(int $id, array $attributes): User
    {
        $user = $this->getUser($id);

        $user->email = $attributes['email'] ?? $user->email;
        $user->name = $attributes['name'] ?? $user->name;
        $user->role = $attributes['role'] ?? $user->role;

        $user->save();

        return $user;
    }

    /**
     * @return User
     * @param array<string,string> $attributes
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    public function getAll(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function getUser(int $id): ?User
    {
        $user = $this->userRepository->getUserById($id);
        if (!$user) {
            throw new ModelNotFoundException(sprintf('User with %d id does not exits', $id));
        }

        return $user;
    }
}
