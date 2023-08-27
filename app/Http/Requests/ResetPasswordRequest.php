<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'code.required' => 'The code is required.',
            'code.exists' => 'The provided code does not exist.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters long.',
            'c_password.required' => 'Please confirm the password.',
            'c_password.same' => 'The password confirmation does not match the password.',
        ];
    }
}
