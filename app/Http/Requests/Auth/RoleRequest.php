<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        $role = request()->route('role');

        return [
            'auth.role.name' => [
                'required',
                'max:255',
                Rule::unique('auth_roles', 'name')->ignore($role),
            ],
            'auth.role.description' => [
                'max:255',
            ],
            'auth.role.is_enabled' => [
                'required',
                'boolean',
            ],
            'auth.role.is_published' => [
                'required',
                'boolean',
            ],
        ];
    }
}
