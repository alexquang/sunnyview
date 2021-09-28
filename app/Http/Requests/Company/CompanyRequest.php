<?php

namespace App\Http\Requests\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'company.company_name' => [
                'required',
                'max:255',
            ],
            'company.contact_email' => [
                'required',
                'email' => 'email:rfc,dns',
                'confirmed',
            ],
            'company.contact_email_confirmation' => [
                'required',
                'email' => 'email:rfc,dns',
            ],
            'company.department_name' => [
                'max:255',
            ],
            'company.position_name' => [
                'max:255',
            ],
            'company.person_in_charge' => [
                'max:255',
            ],
            'company.contact_name' => [
                'max:255',
            ],
            'company.contact_phone_number' => [
                'nullable',
                'max:255',
                'regex:/^\d{10}$|^\d{11}$/',
            ],
            'company.contact_address_1' => [
                'max:255',
            ],
            'company.contact_address_2' => [
                'max:255',
            ],
            'company.contact_address_3' => [
                'max:255',
            ],
            'company.contact_postal_code' => [
                'nullable',
                'max:255',
                'regex:/^\d{3}[-]\d{4}$|^\d{3}[-]\d{2}$|^\d{3}$/',
            ],
            'company.aws_usage_account_id' => [
                'nullable',
                'numeric',
                Rule::exists('aws_accounts', 'account_id')->whereNull('deleted_at'),
            ],
            'company.invoice_title' => [
                'max:255',
            ],
            'company.invoice_issue_date' => [
                Rule::in(array_column(Company::INVOICE_DATE_OPTIONS, 'key')),
            ],
            'company.invoice_pay_date' => [
                Rule::in(array_column(Company::PAY_DAY_OPTIONS, 'key')),
            ],
            'company.invoice_format_type' => [
                Rule::in(array_column(Company::INVOICE_TYPE_OPTIONS, 'key')),
            ],
            'company.invoice_commission_fee' => [
                'nullable',
                'numeric',
                'digits_between:0,9',
            ],
            'company.invoice_discount_rate' => [
                'nullable',
                'numeric',
            ],
            'company.invoice_delivery_method' => [
                Rule::in(array_column(Company::DELIVERY_OPTIONS, 'key')),
            ],
            'company.is_invoice_est_enabled' => [
                'boolean',
            ],
            'company.is_invoice_nohin_enabled' => [
                'boolean',
            ],
            'company.bank_issuer' => [
                Rule::in(array_column(Company::BANK_ACCOUNT_OPTIONS, 'key')),
            ],
            'company.credit_card_issuer' => [
                Rule::in(array_column(Company::CREDIT_CARD_ISSUER, 'key')),
            ],
            'company.credit_card_number' => [
                'nullable',
                'max:255',
                'regex:/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/',
            ],
            'company.notes' => [
                'max:255',
            ],
        ];

        return $rules;
    }
}
