<?php

namespace Modules\Accounts\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "code" => ['required', 'max:50', 'unique:sub_ledgers,code,'.decrypt($this->id)],
            "email" => 'nullable|email|unique:sub_ledgers,email,'.decrypt($this->id),
            "ledger_id" => "required|gt:0",
            "is_active" => "nullable|in:0,1",
            "bank_name" => "nullable",
            "bank_ac_name" => "nullable",
            "ac_no" => "nullable",
            "routing_no" => "nullable",
            "swift_code" => "nullable",
            "branch_code" => "nullable",
            "sub_ledger_type_id" => "nullable",
            "type" => "required|in:Client,Vendor,Staff",
            "tin" => "nullable",
            "bin" => "nullable",
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
            'type.in' => 'The Partner Type must be one of the following types: :values',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->request->get('is_active') ? 1 : 0,
        ]);
    }
}
