<?php

namespace Database\Factories;

use App\Models\AuthPermission;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AuthPermission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
