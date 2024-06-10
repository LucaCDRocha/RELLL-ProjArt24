<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrailUpdateRequest extends FormRequest
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
            'difficulty' => 'required| in:1,2,3', // Facile, Moyen, Difficle
            'info_transport' => 'max:255',
            'info_transport' => 'max:255',
            'is_accessible' => 'required',
            'img' => 'file|mimes:jpeg,png,jpg',
        ];
    }
}
