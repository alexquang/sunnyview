<?php

namespace Database\Factories;

use App\Models\AuthRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AuthRole::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
