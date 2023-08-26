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

    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->email;
        $password = $request->password;
        $user = $this->userRepository->getUserByMail($email);

        if(!$user || Hash::check($password, $user->password)) {

            return response()->json(
                [
                    'message' => 'Incorrect credentials.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $token = $user->createToken('API TOKEN');

        return response()->json(
            [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer'
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(
            [
                'message' => 'You are logged out,'
            ]
        );
    }
}
