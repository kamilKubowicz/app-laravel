<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email format is invalid.',
            'password.required' => 'The password field is required.',
        ];
    }
}
