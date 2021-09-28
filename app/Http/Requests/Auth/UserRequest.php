<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

        $rule = [
            'auth.user.name' => [
                'required',
                'max:255',
            ],
            'auth.user.email' => [
                'max:255',
                'required',
                'email' => 'email:rfc,dns',
                Rule::unique('auth_users', 'email')->ignore($user)->whereNull('deleted_at'),
            ],
            'auth.user.is_enabled' => [
                'required',
                'boolean',
            ],
        ];
        if (!$user) {
            $rule['auth.user.password'] = [
                'max:255',
                'required',
            ];
        }

        return $rule;
    }
}
