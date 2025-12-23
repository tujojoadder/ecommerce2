<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierPaymentRequest extends FormRequest
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
            'supplier_id' => ['required', 'numeric'],
            'invoice_id' => ['nullable', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'payment_id' => ['required', 'numeric'],
            'account_id' => ['required', 'numeric'],
            'bank_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric']
        ];
    }
}
