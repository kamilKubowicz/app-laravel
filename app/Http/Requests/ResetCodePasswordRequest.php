<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Str;

class ResetCodePasswordRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'The provided email does not exist in our records.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return [
            'email' => request()->email,
            'code' => Str::random(15),
            'created_at' => now()
        ];
    }
}
