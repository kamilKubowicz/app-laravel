<?php
declare(strict_types=1);

namespace App\Http\Requests;

class PostNewRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field cannot be longer than :max characters.',
            'title.min' => 'The title must be at least :min characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description field must be a string.',
            'image.required' => 'The image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: :values.',
            'image.max' => 'The image file size cannot be larger than :max kilobytes.',
        ];
    }
}
