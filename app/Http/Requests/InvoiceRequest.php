<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'client_id' => ['required'],
            'issued_date' => ['required', 'string', 'max:20'],
            'issued_time' => ['required', 'string', 'max:10'],
            'discount_type' => ['nullable', 'string', 'max:20'],
            'discount' => ['nullable', 'numeric'],
            'transport_fare' => ['nullable', 'numeric'],
            'labour_cost' => ['nullable', 'numeric'],
            'account_id' => ['required'],

            'bank_id' => ['nullable'],
            'cheque_number' => ['nullable', 'string', 'max:100'],
            'cheque_issued_date' => ['nullable', 'string', 'max:20'],

            'category_id' => ['nullable'],
            'receive_amount' => ['required', 'numeric'],
            'bill_amount' => ['required', 'numeric'],
            'due_amount' => ['required', 'numeric'],
            'highest_due' => ['nullable', 'numeric'],
            'vat_type' => ['nullable', 'string', 'max:10'],
            'vat' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'send_sms' => ['nullable'],
            'send_email' => ['nullable'],
        ];
    }
}
