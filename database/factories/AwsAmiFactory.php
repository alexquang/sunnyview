<?php

namespace Database\Factories;

use App\Models\AwsAmi;
use Illuminate\Database\Eloquent\Factories\Factory;

class AwsAmiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AwsAmi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image_id' => $this->faker->uuid(),
        ];
    }
}
