<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function getCollection(int $perPage, int $currentPage): LengthAwarePaginator
    {
        return Post::with(
            ['author' => function ($query) {
                    $query->select('id', 'name');
                }
            ]
        )->paginate($perPage, ['*'], 'page', $currentPage);
    }

    public function getById(int $id): ?Post
    {
       return Post::find($id);
    }
}
