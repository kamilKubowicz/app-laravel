<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Interfaces\PostRepositoryInterface;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PostServiceTest extends TestCase
{
    private MockObject&UserService $userService;

    private MockObject&PostRepositoryInterface $postRepository;

    private PostService $postService;

    protected function setUp(): void
    {
        $this->userService = $this->createMock(UserService::class);
        $this->postRepository = $this->createMock(PostRepositoryInterface::class);

        $this->postService = new PostService(
            $this->userService,
            $this->postRepository
        );
    }

    public function testGetCollection(): void
    {
        $resultMock = $this->createMock(LengthAwarePaginator::class);
        $perPage = 10;
        $page = 1;

        $this->postRepository
            ->expects($this->once())
            ->method('getCollection')
            ->with($perPage, $page)
            ->willReturn($resultMock);

        $this->postService->getCollection($perPage, $page);
    }
}
