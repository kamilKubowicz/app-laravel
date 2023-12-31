<?php
declare(strict_types=1);

namespace App\Http\Requests;
use App\Http\Requests\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:15',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'role' => 'nullable|in:user,admin,editor',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email format is invalid.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :min characters.',
            'c_password.required' => 'The confirm password field is required.',
            'c_password.same' => 'The confirm password must match the password.',
            'role.in' => 'The role must be one of: user, admin.',
        ];
    }
}
