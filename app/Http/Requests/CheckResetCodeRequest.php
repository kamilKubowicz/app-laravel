<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class CheckResetCodeRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|exists:reset_code_passwords',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'code.required' => 'The code field is required.',
            'code.string' => 'The code must be a string.',
            'code.exists' => 'The provided code is invalid.',
        ];
    }
}
