<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PaginationRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'perPage' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'perPage.required' => 'The perPage field is required.',
            'perPage.integer' => 'The perPage field must be an integer.',
            'perPage.min' => 'The perPage field must be at least 1.',
            'perPage.max' => 'The perPage field may not be greater than 100.',
            'page.required' => 'The page field is required.',
            'page.integer' => 'The page field must be an integer.',
            'page.min' => 'The page field must be at least 1.',
        ];
    }
}
