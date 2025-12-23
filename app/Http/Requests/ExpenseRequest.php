<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'date' => ['required', 'string', 'max:20'],
            'account_id' => ['required'],
            'amount' => ['required', 'numeric'],
            'category_id' => ['required'],
            'subcategory_id' => ['nullable'],
            'payment_id' => ['nullable'],
            'bank_id' => ['nullable'],
            'checkout_no' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'mimes:png,jpg'],
            'description' => ['nullable', 'string'],
        ];
    }
}
