<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'invoice_id' => ['nullable', 'numeric'],
            'supplier_id' => ['required', 'numeric'],
            'stock_id' => ['nullable', 'numeric'],
            'warehouse_id' => ['nullable', 'numeric'],
            'issued_date' => ['required', 'string', 'max:20'],
            'discount' => ['nullable', 'numeric'],
            'discount_type' => ['nullable', 'string'],
            'transport_fare' => ['nullable', 'numeric'],
            'vat_type' => ['nullable', 'string'],
            'vat' => ['nullable', 'numeric'],
            'account_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'receive_amount' => ['required', 'numeric'],
            'purchase_bill' => ['required', 'numeric'],
            'total_vat' => ['required', 'numeric'],
            'total_discount' => ['required', 'numeric'],
            'grand_total' => ['required', 'numeric'],
            'total_due' => ['required', 'numeric'],
        ];
    }
}
