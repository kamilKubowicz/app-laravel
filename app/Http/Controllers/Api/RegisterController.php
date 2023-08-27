<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function __construct(private readonly UserService $userService)
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
        try {
            $user = $this->userService->create($attributes);

            return new JsonResponse(
                [
                    'message' => 'Registration successful.',
                    'token' => $user->createToken('API TOKEN')->plainTextToken
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'message' => 'Registration failed.'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
