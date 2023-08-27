<?php

namespace App\Interfaces;

use App\Models\ResetCodePassword;

interface ResetCodePasswordRepositoryInterface
{
    public function getByMail(string $mail): ?ResetCodePassword;
    public function getByCode(string $code): ?ResetCodePassword;
}
