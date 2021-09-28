<?php

namespace Database\Factories;

use App\Models\AwsAccount;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = Company::factory()->create();

        return [
            'ym' => $this->faker->date('Y-m'),
            'company_name' => $company->company_name,
            'contact_email' => $company->contact_email,
            'aws_usage_account_id' => $company->awsAccount->account_id,
            'aws_usage_account_name' => $company->awsAccount->account_name,
            'invoice_delivery_method' =>  $company->invoice_delivery_method,
        ];
    }
}
