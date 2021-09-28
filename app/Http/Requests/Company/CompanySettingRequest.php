<?php

namespace App\Http\Requests\Company;

use App\Models\CompanySetting;
use Illuminate\Foundation\Http\FormRequest;

class CompanySettingRequest extends FormRequest
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
        $rules = [
            'company.settings.' . CompanySetting::KEY_BILLING_ALERT . '.value' => [
                'required',
                'numeric',
                'digits_between:0,9'
            ],
        ];

        return $rules;
    }
}
