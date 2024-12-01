<?php

namespace Modules\Accounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Accounts\App\Models\Ledger;

class WorkOrderSitetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "work_order_id" => "required|gt:0",
            "site_name" => "required",
            "est_budget" => "required",
            "site_location" => "nullable",
            "site_pm_name" => "nullable",
            "note" => "nullable",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
