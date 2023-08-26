<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserDeleteOrShowRequest;
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
            return response()->json(
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

            return response()->json(
                [
                    'message' => 'User has been added.',
                    'user' => $user
                ]
            );
        } catch (\Exception) {

            return response()->json(
                [
                    'message' => 'An error occurred while adding a user.'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function remove(UserDeleteOrShowRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasAdminPermission()) {
                return $this->sendPermissionDeniedResponse();
            }
            $id = (int) $request->id;
            $this->userService->deleteUser($id);

            return response()->json(
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

    public function edit(UserEditRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasAdminPermission()) {
                return $this->sendPermissionDeniedResponse();
            }
            $editedUser = $this->userService->editUser($request->only('id', 'name', 'email', 'role'));

            return response()->json(
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
