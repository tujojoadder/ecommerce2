<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'id_no' => ['nullable', 'string', 'max:50'],
            'client_name' => ['required', 'string', "max:100"],
            'company_name' => ['nullable', 'string', 'max:200'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'phone_optional' => ['nullable', 'string'],
            'previous_due' => ['nullable'],
            'max_due_limit' => ['nullable'],
            'email' => ['nullable', 'email', 'max:60'],
            'date_of_birth' => ['nullable', 'string'],
            'upazilla_thana' => ['nullable', 'string'],
            'zip_code' => ['nullable', 'string'],
            'group_id' => ['nullable', 'numeric'],
            'status' => ['nullable'],
            'image' => ['mimes:png,jpg', 'nullable'],
        ];
    }
}
