<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class UserDeleteOrShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The id field is required.',
        ];
    }
}
