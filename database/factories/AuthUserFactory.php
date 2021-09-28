<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\AuthUser;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AuthUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AuthUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $img = $this->faker->image('public/storage/avatars', 400, 300, null, false);
        $company = Company::factory()->create();

        $group = Group::factory()->create(['company_id' => $company->id]);

        return [
            'company_id' => $company->id,
            'group_id' => $group->id,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => \Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
