<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $group = request()->route('group');

        return [
            'company.group.name' => [
                'required',
                'max:255',
                Rule::unique('groups', 'name')->ignore($group),
            ],
            'company.group.description' => [
                'max:255',
            ],
        ];
    }
}
