<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $group = Group::factory()->create();

        return [
            'company_id' => $group->company_id,
            'group_id' => $group->id,
            'name' => $this->faker->unique()->word(),
            'alias' => $this->faker->unique()->word(),
        ];
    }
}
