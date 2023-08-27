<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\IdRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostNewRequest;
use App\Http\Requests\UserEditRequest;
use App\Services\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends BaseController
{
    public function __construct(private readonly PostService $postService)
    {
    }

    public function index(PaginationRequest $request): JsonResponse
    {
        try {
            $perPage = $request->perPage ?? 10;
            $page = $request->page ?? 1;

            $posts = $this->postService->getCollection((int) $perPage, (int) $page);

            return response()->json(
                [
                    'posts' => $posts,
                ]
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function new(PostNewRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasEditorPermission()) {
                return $this->sendPermissionDeniedResponse();
            }

            $attributes = [
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->file('image')->store('image')
            ];

            $post = $this->postService->create((int) $user->id, $attributes);

            return response()->json(
                [
                    'message' => 'Post has been created.',
                    'post' => $post
                ]
            );
        } catch (\Exception) {
            return $this->sendError(
                'An error occurred while adding an article. Try again.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function remove(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasEditorPermission()) {
                return $this->sendPermissionDeniedResponse();
            }
            $this->postService->deletePost((int) $id);

            return response()->json(
                [
                    'message' => sprintf('Post with id = %d has been removed.', $id)
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(PostEditRequest $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user || !$user->hasEditorPermission()) {
                return $this->sendPermissionDeniedResponse();
            }

            $attributes = [
                'title' => $request->title,
                'description' => $request->description,
                'image' => null
            ];

            if ($request->hasFile('image')) {
                $attributes['image'] = $request->file('image')->store('image');
            }

            $post = $this->postService->editPost((int) $id, $attributes);

            return response()->json(
                [
                    'message' => 'Post has been edited',
                    'post' => $post
                ]
            );
        } catch (ModelNotFoundException $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
