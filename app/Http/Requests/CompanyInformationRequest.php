<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyInformationRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:100'],
            'company_type' => ['required', 'string', 'max:100'],
            'logo' => ['required', 'mimes:png,jpg'],
            'homepage_banner' => ['required', 'mimes:png,jpg'],
            'invoice_header' => ['required', 'mimes:png,jpg'],
            'country' => ['required', 'string', 'max:50'],
            'address1' => ['required', 'string', 'max:200'],
            'address2' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:60'],
            'phone' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:50'],
            'post_code' => ['required', 'string', 'max:20'],
            'stock_warning' => ['required'],
            'currency_symbol' => ['required', 'string', 'max:1'],
            'sms_api_code' => ['required', 'string', 'max:200'],
            'sms_api_sender' => ['required', 'string', 'max:100'],
            'sms_api_provider' => ['required', 'string', 'max:100'],
            'sms_api_setting' => ['required', 'string', 'max:100'],

        ];
    }
}
