<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected function sendPermissionDeniedResponse(): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => 'Permission denied.',
            ],
            Response::HTTP_FORBIDDEN
        );
    }

    protected function sendError(string $message, int $status): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => $message
            ],
            $status
        );
    }
}
