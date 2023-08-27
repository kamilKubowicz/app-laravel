<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends BaseController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasAdminPermission()) {
                return $this->sendPermissionDeniedResponse();
            }

            $users = $this->userService->getAll();
            return new JsonResponse(
                [
                    'users' => $users
                ]
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function new(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasAdminPermission()) {
                return $this->sendPermissionDeniedResponse();
            }

            $attributes = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role ?? User::ROLE_USER,
            ];

            $user = $this->userService->create($attributes);

            return new JsonResponse(
                [
                    'message' => 'User has been added.',
                    'user' => $user
                ]
            );
        } catch (\Exception) {

            return new JsonResponse(
                [
                    'message' => 'An error occurred while adding a user.'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function remove(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasAdminPermission()) {
                return $this->sendPermissionDeniedResponse();
            }
            $this->userService->deleteUser((int) $id);

            return new JsonResponse(
                [
                    'message' => sprintf('User with id = %d has been removed.', $id)
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(UserEditRequest $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasAdminPermission()) {
                return $this->sendPermissionDeniedResponse();
            }
            $editedUser = $this->userService->editUser((int) $id, $request->only('name', 'email', 'role'));

            return new JsonResponse(
                [
                    'message' => 'User has been edited',
                    'user' => $editedUser
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
