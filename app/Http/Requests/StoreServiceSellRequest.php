<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceSellRequest extends FormRequest
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
            'customer_id' => 'nullable|integer',
            'sell_date' => 'required',
            'sell_status' => 'nullable',
            'service_charge' => 'nullable',
            'reference_no' => 'nullable',
            'bar_code' => 'nullable',
            'product_id' => 'required|exists:item_infos,id',
            'product_name' => 'required|string|exists:item_infos,name',
            'product_qty' => 'required',
            'product_discount' => 'nullable|exists:item_infos,discount',
            'product_tax' => 'nullable|numeric|exists:item_infos,tax',
            'product_total_amount' => 'required|numeric',
            'others_charge' => 'nullable|string',
            'others_charge_amount' => 'nullable|string',
            'discount_type' => 'nullable',
            'discount' => 'nullable|string',
            'extra_discount' => 'nullable',
            'sales_note' => 'nullable',
            'total_payable_amount' => 'required|numeric',
            'payment_type' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'sell_date.required' => 'The sell date field is required.',
            'product_id.required' => 'The product ID field is required.',
            'product_id.exists' => 'The selected product ID is invalid.',
            'product_name.required' => 'The product name field is required.',
            'product_name.exists' => 'The selected product name is invalid.',
            'product_total_amount.required' => 'The total amount field is required.',
            'product_total_amount.numeric' => 'The total amount must be a number.',
            'product_tax.numeric' => 'The product tax must be a number.',
            'total_payable_amount.required' => 'The total payable amount field is required.',
            'total_payable_amount.numeric' => 'The total payable amount must be a number.',
        ];
    }
}
