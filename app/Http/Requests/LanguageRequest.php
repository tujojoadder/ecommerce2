<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => ['required', 'string', 'max:100'],
            'arabic' => ['nullable', 'string', 'max:100'],
            'bangla' => ['nullable', 'string', 'max:100'],
            'english' => ['nullable', 'string', 'max:100'],
            'hindi' => ['nullable', 'string', 'max:100'],
        ];
    }
}
