<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiveRequest extends FormRequest
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
            'client_id' => ['nullable', 'numeric'],
            'supplier_id' => ['nullable', 'numeric'],
            'invoice_id' => ['nullable', 'numeric'],
            'date' => ['nullable', 'string', 'max:20'],
            'account_id' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric'],
            'current_balance' => ['nullable', 'numeric'],
            'project_id' => ['nullable', 'numeric'],
            'chart_account_id' => ['nullable', 'numeric'],
            'chart_group_id' => ['nullable', 'numeric'],
            'category_id' => ['nullable', 'numeric'],
            'payment_id' => ['nullable', 'numeric'],
            'bank_id' => ['nullable', 'numeric'],
            'cheque_no' => ['nullable', 'string', 'max:100'],
            'send_sms' => ['nullable'],
            'send_email' => ['nullable'],
        ];
    }
}
