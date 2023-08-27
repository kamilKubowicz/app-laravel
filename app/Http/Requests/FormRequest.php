<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FormRequest extends BaseFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(new JsonResponse(
            [
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
