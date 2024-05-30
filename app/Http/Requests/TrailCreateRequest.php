<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrailCreateRequest extends FormRequest
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
            // 'name' => 'required|min:2',
            // 'time' => '', //  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! rajout d'une limite ?
            // 'description' => 'max:255',
            // 'difficulty' => 'between:1,3',
            // 'info_transport' => 'max:255',

        ];
    }
}
