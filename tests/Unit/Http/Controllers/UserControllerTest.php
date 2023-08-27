<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use App\Http\Controllers\Api\UserController;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;

class UserControllerTest extends TestCase
{
    private MockObject|UserService $userService;
    private UserController $userController;

    protected function setUp(): void
    {
        $this->userService = $this->createMock(UserService::class);
        $this->userController = new UserController($this->userService);
    }

    public function testIndexWithAdminUser()
    {
        $adminUser = new User();
        $adminUser->role = 'admin';
        $request = $this->createMock(Request::class);

        $this->userService->expects($this->once())
            ->method('getAll')
            ->willReturn(new Collection([new User(), new User()]));

        $request->expects($this->once())->method('user')->willReturn($adminUser);

        $response = $this->userController->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('users', $response->getData(true));
    }

    public function testIndexWithNonAdminUser()
    {
        $nonAdminUser = new User();
        $nonAdminUser->role = 'user';

        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('user')->willReturn($nonAdminUser);

        $response = $this->userController->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testNewWithAdminUser()
    {
        $adminUser = new User();
        $adminUser->role = 'admin';

        $request = $this->createMock(RegisterRequest::class);
        $request->expects($this->once())->method('user')->willReturn($adminUser);
        $request->name = 'John Doe';
        $request->email = 'johndoe@example.com';
        $request->password = 'secret';
        $request->role = 'user';

        $this->userService->expects($this->once())
            ->method('create')
            ->with([
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => 'secret',
                'role' => 'user',
            ])
            ->willReturn(new User());

        $response = $this->userController->new($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('message', $response->getData(true));
        $this->assertArrayHasKey('user', $response->getData(true));
    }

    public function testRemoveWithAdminUser()
    {
        $adminUser = new User();
        $adminUser->role = 'admin';

        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('user')->willReturn($adminUser);

        $userId = 1;

        $this->userService->expects($this->once())
            ->method('deleteUser')
            ->with($userId);

        $response = $this->userController->remove($request, $userId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('message', $response->getData(true));
    }

    public function testEditWithAdminUser()
    {
        $adminUser = new User();
        $adminUser->role = 'admin';
        $userId = 1;
        $attr = [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
            'role' => 'admin',
        ];
        $request = $this->createMock(UserEditRequest::class);
        $request->name = 'New Name';
        $request->email = 'newemail@example.com';
        $request->role = 'admin';

        $request->expects($this->once())->method('user')->willReturn($adminUser);
        $request
            ->expects($this->once())
            ->method('only')
            ->with('name', 'email', 'role')
            ->willReturn($attr);



        $this->userService->expects($this->once())
            ->method('editUser')
            ->with(
                $userId,
                [
                    'name' => 'New Name',
                    'email' => 'newemail@example.com',
                    'role' => 'admin',
                ]
            )
            ->willReturn(new User());

        $response = $this->userController->edit($request, $userId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('message', $response->getData(true));
        $this->assertArrayHasKey('user', $response->getData(true));
    }
}
