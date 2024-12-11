<?php

namespace Modules\Accounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Accounts\App\Models\Ledger;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:900',
            "name" => ['required', 'min:5', 'unique:products,name,'.decrypt($this->id)],
            "type" => "required|string|in:Service,Product",
            "purchase_ledger_id" => "required|gt:0",
            "selling_ledger_id" => "required|gt:0",
            "product_unit_id" => "required|gt:0",
            "is_active" => "required|string|in:Yes,No",
            "for_selling" => "required|string|in:Yes,No",
            "for_purchase" => "required|string|in:Yes,No",
            "selling_price" => "required|gt:0",
            "purchase_price" => "required|gt:0",
            "selling_price_tax" => "required|min:0|max:100",
            "purchase_price_tax" => "required|min:0|max:100",
            "details" => "nullable",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'type.in' => 'The Product Type must be one of the following types: :values',
        ];
    }
}
