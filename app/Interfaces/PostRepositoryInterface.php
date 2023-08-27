<?php

namespace App\Interfaces;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getCollection(int $perPage, int $currentPage): LengthAwarePaginator;

    public function getById(int $id): ?Post;
}
