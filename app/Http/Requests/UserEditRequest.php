<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class UserEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required',
            'name' => 'nullable|min:3|max:15',
            'email' => 'nullable|email',
            'role' => 'nullable|in:user,admin,editor',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The id field is required.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'email.email' => 'The email format is invalid.',
            'role.in' => 'The role must be one of: user, admin.',
        ];
    }
}
