<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private const TOKEN_NAME = 'API TOKEN';
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->email;
        $password = $request->password;
        $user = $this->userRepository->getUserByMail($email);

        if(!$user || !Hash::check($password, $user->password)) {

            return new JsonResponse(
                [
                    'message' => 'Incorrect credentials.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $token = $user->createToken(self::TOKEN_NAME);
        $isSpecialUser = $user->role !== 'user';

        return new JsonResponse(
            [
                'access_token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'is_special_user' => $isSpecialUser
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();

        return new JsonResponse(
            [
                'message' => 'You are logged out,'
            ]
        );
    }
}
