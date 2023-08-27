<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\ResetCodePasswordRepositoryInterface;
use App\Models\ResetCodePassword;

class ResetCodePasswordRepository implements ResetCodePasswordRepositoryInterface
{
    public function getByMail(string $mail): ?ResetCodePassword
    {
        return ResetCodePassword::firstWhere('email', $mail);
    }

    public function getByCode(string $code): ?ResetCodePassword
    {
        return ResetCodePassword::firstWhere('code', $code);
    }
}
