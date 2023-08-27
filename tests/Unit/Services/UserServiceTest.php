<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface&MockObject $userRepository;
    private UserService $userService;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function testGetAllUsers()
    {
        $usersMock = $this->createMock(Collection::class);

        $this->userRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($usersMock);

        $result = $this->userService->getAll();

        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetUser()
    {
        $userId = 1;
        $userMock = $this->createMock(User::class);

        $this->userRepository->expects($this->once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn($userMock);

        $result = $this->userService->getUser($userId);

        $this->assertInstanceOf(User::class, $result);
    }

    public function testUpdateUser()
    {
        $email = 'johndoe@example.com';
        $newPassword = 'newsecret';

        $userMock = $this->createMock(User::class);

        $this->userRepository->expects($this->once())
            ->method('getUserByMail')
            ->with($email)
            ->willReturn($userMock);

        $userMock->expects($this->once())
            ->method('update')
            ->with(['password' => $newPassword]);

        $this->userService->updateUser($email, $newPassword);
    }
}
