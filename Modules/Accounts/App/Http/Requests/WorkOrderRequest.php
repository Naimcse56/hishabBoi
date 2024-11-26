<?php

namespace Modules\Accounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "sub_ledger_id" => "required|numeric|gt:0",
            "order_name" => "required",
            "order_no" => "required",
            // "cost_amount" => "required|numeric|gt:0",
            "is_active" => "required|in:0,1",
            // "create_date" => "required",
            "remarks" => "nullable"
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
            'cost_amount.gt' => 'Amount must be greater or equal 0.00',
        ];
    }
}
