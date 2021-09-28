<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PermissionAttachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions.*.id' => [
                'required',
                'numeric',
            ],
            'permissions.*.selected' => [
                'required',
                'boolean',
            ],
            'permissions.*.rule' => [
                'in:allow,deny'
            ],
            'permissions.*.scope' => [
                'max:255',
            ],
        ];
    }
}
