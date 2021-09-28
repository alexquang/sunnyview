<?php

namespace Database\Seeders;

use App\Models\AuthRole;
use Illuminate\Database\Seeder;

class AuthRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::transaction(function () {
            AuthRole::truncate();

            AuthRole::insert([
                ['name' => 'admin', 'is_published' => true],
                ['name' => 'manager', 'is_published' => true],
                ['name' => 'ids-admin', 'is_published' => false],
                ['name' => 'ids-developer', 'is_published' => false],
                ['name' => 'ids-tester', 'is_published' => false],
            ]);
        });
    }
}
