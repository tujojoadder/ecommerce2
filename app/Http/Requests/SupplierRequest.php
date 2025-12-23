<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'supplier_name' => ['required', 'string', 'max:100'],
            'company_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string'],
            'phone_optional' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:100'],
            'previous_due' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string', 'max:200'],
            'city_state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:100'],
            'country_name' => ['nullable', 'string', 'max:100'],
            'domain' => ['nullable', 'string', 'max:100'],
            'bank_account' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'mimes:png,jpg'],
            'group_id' => ['nullable', 'numeric'],
            'status' => ['nullable', 'numeric'],
        ];
    }
}
