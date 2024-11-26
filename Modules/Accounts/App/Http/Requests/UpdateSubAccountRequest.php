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
        // $v_id = decrypt($this->id);
        return [
            "name" => "required",
            "code" => ['required', 'max:50'],
            'type' => 'required|array|min:1',
            "type.*" => "string|in:Customer,Supplier,Member,LandOwner",
            "is_active" => "required|in:0,1",
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
}
