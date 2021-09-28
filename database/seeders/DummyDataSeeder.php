<?php

namespace Database\Seeders;

use App\Models\AuthRole;
use App\Models\Company;
use App\Models\Group;
use App\Models\Project;
use App\Models\AuthUser;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AuthUser::truncate();
        Project::truncate();
        Group::truncate();
        Company::truncate();

        $this->call([
            AuthUserSeeder::class,
            AuthAbilitySeeder::class,
        ]);

        Company::factory()->count(2)->create()->each(function ($company) {
            Group::factory()->count(2)->create([
                'company_id' => $company->id,
            ])->each(function ($group) {
                AuthUser::factory()->count(2)->create([
                    'company_id' => $group->company_id,
                    'group_id' => $group->id,
                ]);

                Project::factory()->count(2)->create([
                    'company_id' => $group->company_id,
                    'group_id' => $group->id,
                ]);
            });
        });
        AuthUser::factory()->count(10)->create([
            'company_id' => null,
        ]);
    }
}
