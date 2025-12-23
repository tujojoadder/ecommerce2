<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetAndStockRequest extends FormRequest
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
            'asset_type' => ['required'],
            'date' => ['required'],
            'supplier_id' => ['required'],
            'product_id' => ['required'],
           // 'unit' => ['required'],
            'quantity' => ['required'],
            'rate' => ['required'],
            'total_amount' => ['required'],
           // 'account' => ['required'],
           // 'category' => ['required'],
          // 'chart_of_account_id' => ['required'],
          //  'chart_of_account_group_id' => ['required'],
           // 'voucher_no' => ['required'],
           // 'id_no' => ['required'],
           // 'description' => ['required'],
            'type' => ['required'],
        ];
    }
}
