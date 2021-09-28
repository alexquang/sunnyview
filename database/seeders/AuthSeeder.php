<?php

namespace Database\Seeders;

use App\Models\AuthUser;
use Illuminate\Database\Seeder;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AuthUserSeeder::class,
            AuthPermissionSeeder::class,
            AuthRoleSeeder::class,
            AuthAbilitySeeder::class,
        ]);
    }
}
