<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(
      private readonly UserService $userService,
      private readonly PostRepositoryInterface $postRepository
    ) {
    }

    /**
     * @param string[] $attributes
     */
    public function create(int $userId, array $attributes): Model
    {
        $user = $this->userService->getUser($userId);

        return $user->posts()->create($attributes);
    }

    public function getCollection(?int $perPage, ?int $page): LengthAwarePaginator
    {
       return $this->postRepository->getCollection($perPage, $page);
    }

    public function deletePost(int $id)
    {
        $post = $this->getPost($id);
        $post->delete();
    }

    public function editPost(int $id, array $attributes): Post
    {
        $post = $this->getPost($id);
        $attributes = array_filter($attributes);

        $post->update($attributes);

        return $post;
    }

    private function getPost(int $id): ?Post
    {
        $post = $this->postRepository->getById($id);
        if (!$post) {
            throw new ModelNotFoundException(sprintf('User with %d id does not exits', $id));
        }

        return $post;
    }
}
