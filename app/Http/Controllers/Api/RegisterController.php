<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        //By default, the role should be set as user, and the other roles should be assigned by the super admin
        // (editor,admin) from the panel. The super admin itself should be created by the command

        $attributes = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role ?? User::ROLE_USER,
        ];
        $this->userRepository->create($attributes);

        return response()->json([
            'message' => 'Registration successful'
        ]);
    }
}
