<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterestPointCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'description' => 'required|max:255',
            // 'url' => 'url',
            'tags' => 'required| min:1',
            'seasons' => 'required| min:1',
            'imgs' => 'required|mimes:jpeg,png,jpg',
        ];
    }
}
