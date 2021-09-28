<?php

namespace Database\Factories;

use App\Models\AwsAccount;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->company(),
            'contact_email' => $this->faker->companyEmail(),
            'aws_usage_account_id' => AwsAccount::factory()->create()->account_id,
            'invoice_delivery_method' =>  $this->faker->randomElement([null, 'post']),
        ];
    }
}
