<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemInfoRequest extends FormRequest
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
            'slug' => [
                'required',
                'string',
                'max:120',
                Rule::unique('item_infos')->ignore($this->item_info),
            ],
            'name' => 'required|string|unique:item_infos,name',
            'sku' => 'required',
            'unit' => 'required|string',
            'unit_value' => 'required|string|max:50',
            'published_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'published' => 'nullable|numeric',
            'purchase_price' => 'required|numeric',
            'discount_amount' => 'nullable',
            'discount_type' => 'nullable|integer',
            'tax_amount' => 'nullable',
            'tax' => 'nullable|integer',
            'current_stock' => 'nullable',
            'thumbnail' => 'nullable',
            'status' => 'nullable',
            'stock_status' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.required' => 'The slug field is required.',
            'slug.max' => 'The slug must not be greater than :max characters.',
            'slug.unique' => 'The slug has already been taken.',
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'sku.required' => 'The SKU field is required.',
            'unit.required' => 'The unit field is required.',
            'unit_value.required' => 'The unit value field is required.',
            'unit_value.max' => 'The unit value must not be greater than :max characters.',
            'published_price.required' => 'The published price field is required.',
            'published_price.numeric' => 'The published price must be a number.',
            'sell_price.required' => 'The sell price field is required.',
            'sell_price.numeric' => 'The sell price must be a number.',
            'published.numeric' => 'The published field must be a number.',
            'purchase_price.required' => 'The purchase price field is required.',
            'purchase_price.numeric' => 'The purchase price must be a number.',
            'discount_amount.numeric' => 'The discount amount must be a number.',
            'discount_type.integer' => 'The discount type must be an integer.',
            'tax_amount.numeric' => 'The tax amount must be a number.',
            'tax.integer' => 'The tax type must be an integer.',
            'current_stock.numeric' => 'The current stock must be a number.',
            'thumbnail.image' => 'The thumbnail must be an image.',
            'status.boolean' => 'The status must be a boolean value.',
            'stock_status.boolean' => 'The stock status must be a boolean value.',
        ];
    }



    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
