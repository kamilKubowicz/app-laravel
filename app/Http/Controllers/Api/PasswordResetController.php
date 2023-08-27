<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CheckResetCodeRequest;
use App\Http\Requests\ResetCodePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\UserJob;
use App\Services\ResetCodePasswordService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PasswordResetController extends BaseController
{
    public function __construct(
        private readonly ResetCodePasswordService $passwordService,
        private readonly UserService $userService
    ) {
    }

    public function sendEmail(ResetCodePasswordRequest $request): JsonResponse
    {
        try {
            $resetCodePassword = $this->passwordService->createResetCodePassword($request->data());
            dispatch(
                new UserJob(
                    $resetCodePassword->email,
                    $this->passwordService->prepareLink($resetCodePassword->code)
                )
            );

            return response()->json(
                [
                    'message' => 'The link to change your password was sent to your email.'
                ]
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function checkResetCode(CheckResetCodeRequest $request): JsonResponse
    {
        $passwordReset = $this->passwordService->getCodeByCodeField($request->code);

        if ($passwordReset->isExpire()) {
            return $this->sendError(
            'The link has expired.',
            Response::HTTP_UNPROCESSABLE_ENTITY
             );
        }

        return response()->json(
            [
                'code' => $request->code,
                'message' => 'The code is valid.'
            ]
        );
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $passwordReset = $this->passwordService->getCodeByCodeField($request->code);

        if ($passwordReset->isExpire()) {
            return $this->sendError(
                'The link has expired.',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->userService->updateUser($passwordReset->email, $request->password);

        $passwordReset->delete();

        return response()->json(['message' => 'Password has been changed.']);
    }
}
