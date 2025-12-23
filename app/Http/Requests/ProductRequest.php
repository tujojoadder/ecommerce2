<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:png,jpg'],
            'description' => ['nullable', 'string'],
            'buying_price' => ['required', 'numeric'],
            'selling_price' => ['required', 'numeric'],
            'unit_id' => ['required', 'numeric'],
            'opening_stock' => ['nullable', 'numeric'],
            'group_id' => ['nullable', 'numeric'],
            'carton' => ['nullable'],
            'stock_warning' => ['nullable', 'numeric'],
        ];
    }
}
