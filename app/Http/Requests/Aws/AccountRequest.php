<?php

namespace App\Http\Requests\Aws;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class AccountRequest extends FormRequest
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
        $account = request()->route('account');

        return [
            'aws.account.account_id' => [
                'required',
                'digits:12',
                Rule::unique('aws_accounts', 'account_id')->ignore($account)
            ],
            'aws.account.account_name' => [
                'required',
                'max:255',
            ],
            'aws.account.iam_role_name' => [
                'required',
                'max:255',
            ],
            'aws.account.external_id' => [
                'required',
                'uuid',
            ],
            'aws.account.is_reseller' => [
                'boolean',
            ],
            'aws.account.s3_bucket_dbr' => [
                'required_if:aws.account.is_reseller,true',
                'max:255',
            ],
            'aws.account.s3_bucket_cur' => [
                'required_if:aws.account.is_reseller,true',
                'max:255',
            ],
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->passes() && !\App::environment('testing')) {
            $validator->after(function (Validator $validator) {
                $account = new \App\Models\AwsAccount($this->input('aws.account'));

                $result = (new \App\Helpers\Aws($account))->test();

                if (!$result) {
                    $validator->errors()->add(
                        'aws.account.iam_role_name',
                        translate('@aws.account._messages.error_assume_role')
                    );
                }
            });
        }
    }
}
