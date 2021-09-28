<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rate = request()->route('rate');

        return [
            'invoice.rate.ym' => [
                'required',
                'date_format:Y-m',
                Rule::unique('exchange_rates', 'ym')->ignore($rate),
            ],
            'invoice.rate.value' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                'min:0', 'max:199.99',
            ],
            'invoice.rate.description' => [
                'max:255',
            ],
        ];
    }
}
