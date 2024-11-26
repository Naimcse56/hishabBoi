<?php

namespace Modules\Accounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Accounts\App\Models\Ledger;

class CreateAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "code" => ['required', 'max:50', 'unique:ledgers'],
            "parent_id" => "required|gt:0",
            "is_active" => "required|in:0,1",
            "acc_type" => "required|in:cash,bank,others",
            "bank_ac_name" => "nullable",
            "ac_no" => "nullable",
            "routing_no" => "nullable",
            "swift_code" => "nullable",
            "branch_code" => "nullable",
            "bank_address" => "nullable",
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
            'acc_type.in' => 'The Account Type must be one of the following types: :values',
            'acc_type.in' => 'The Account Type must be one of the following types: :values',
            'is_cost_center.in' => 'The :attribute must be one of the following types: :values',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->request->get('parent_id') > 0) {
            $parent_account = Ledger::find($this->request->get('parent_id'));
            $this->merge([
                'level' => $parent_account ? ($parent_account->level + 1) : 1,
                'parent_id' => $this->request->get('parent_id'),
                'type' => $parent_account ? $parent_account->type : $this->request->get('type'),
            ]);
        } else {
            $this->merge([
                'level' => 1,
                'parent_id' => $this->request->get('parent_id'),
            ]);
        }

    }
}
