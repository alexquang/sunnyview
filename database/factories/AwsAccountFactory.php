<?php

namespace Database\Factories;

use App\Models\AwsAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class AwsAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AwsAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => $this->faker->numerify(str_pad('', 12, '#')),
            'account_name' => $this->faker->company(),
            // 'iam_role_arn' => $this->faker->uuid(),
            'iam_role_name' => $this->faker->sentence(),
            'external_id' => $this->faker->uuid(),
        ];
    }
}
