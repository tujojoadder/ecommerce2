<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'username' => ['nullable', 'unique:users,username', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'phone' => ['nullable'],
            'image' => ['nullable', 'mimes:png,jpg'],
            'fathers_name' => ['nullable', 'string', 'max:50'],
            'mothers_name' => ['nullable', 'string', 'max:50'],
            'present_address' => ['nullable', 'string', 'max:200'],
            'parmanent_address' => ['nullable', 'string', 'max:200'],
            'date_of_birth' => ['nullable', 'string', 'max:20'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'nid' => ['nullable'],
            'birth_certificate' => ['nullable', 'string', 'max:100'],
            'blood_group' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:50'],
            'edu_qualification' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'string', 'max:100'],
            'staff_id' => ['nullable', 'numeric'],
            'staff_type' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'numeric'],
            'designation_id' => ['nullable', 'numeric'],
            'office_zone' => ['nullable', 'string', 'max:100'],
            'joining_date' => ['nullable', 'string', 'max:20'],
            'discharge_date' => ['nullable', 'string', 'max:20'],
            'machine_id' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'marital_status' => ['nullable', 'string'],
        ];
    }
}
