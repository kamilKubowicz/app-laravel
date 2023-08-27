<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\ResetCodePassword;
use App\Repositories\ResetCodePasswordRepository;

class ResetCodePasswordService
{
    public function __construct(private readonly ResetCodePasswordRepository $resetCodePasswordRepository)
    {
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function createResetCodePassword(array $attributes)
    {
        $code = $this->getCodeByMail($attributes['email']);
        if ($code) $code->delete();

        return ResetCodePassword::create($attributes);
    }

    public function prepareLink(string $code): string
    {
        return sprintf('%s/api/password_reset/check_code?code=%s', env('APP_URL'), $code);
    }

    public function getCodeByCodeField(string $code): ?ResetCodePassword
    {
        return $this->resetCodePasswordRepository->getByCode($code);
    }

    private function getCodeByMail(string $email): ?ResetCodePassword
    {
        return $this->resetCodePasswordRepository->getByMail($email);
    }
}
