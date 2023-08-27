<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Interfaces\ResetCodePasswordRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Services\ResetCodePasswordService;
use App\Models\ResetCodePassword;

class ResetCodePasswordServiceTest extends TestCase
{
    private MockObject&ResetCodePasswordRepositoryInterface $passwordRepository;

    private ResetCodePasswordService $passwordService;

    protected function setUp(): void
    {
        $this->passwordRepository = $this->createMock(ResetCodePasswordRepositoryInterface::class);

        $this->passwordService = new ResetCodePasswordService($this->passwordRepository);
    }

    public function testPrepareLink()
    {
        $code = '123456';
        $expectedLink = sprintf('%s/api/password_reset/check_code?code=%s', env('APP_URL'), $code);

        $link = $this->passwordService->prepareLink($code);

        $this->assertEquals($expectedLink, $link);
    }

    public function testGetCodeByCodeField()
    {
        $this->passwordRepository->expects($this->once())
            ->method('getByCode')
            ->willReturn(new ResetCodePassword());

        $code = '123456';
        $result = $this->passwordService->getCodeByCodeField($code);

        $this->assertInstanceOf(ResetCodePassword::class, $result);
    }
}
