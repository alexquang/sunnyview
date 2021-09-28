<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUserRequest extends FormRequest
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
        $user = request()->route('user');

        $rules = [
            'company.user.name' => [
                'required',
                'max:255',
            ],
            'company.user.email' => [
                'max:255',
                'required',
                'email' => 'email:rfc,dns',
                Rule::unique('auth_users', 'email')->ignore($user)
                // ->whereNull('deleted_at'),
            ],
            'company.user.is_enabled' => [
                'required',
                'boolean',
            ],
            'company.user.group_id' => [
                'required',
                Rule::exists('groups', 'id')->whereNull('deleted_at'),
            ],
        ];

        if (!$user) {
            $rules['company.user.password'] = [
                'max:255',
                'required',
                'confirmed',
            ];
            $rules['company.user.password_confirmation'] = [
                'max:255',
                'required',
            ];
        }

        return $rules;
    }
}
