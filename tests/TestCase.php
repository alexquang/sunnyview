<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function makeUser(array|string $permissions = [], array $overrides = [])
    {
        $user = \App\Models\AuthUser::factory()->create($overrides);
        $permissions = \Arr::wrap($permissions ?: null);

        if (count($permissions)) {
            foreach ($permissions as $permission) {
                $permission = \App\Models\AuthPermission::factory()->create([
                    'name' => $permission,
                ]);

                $user->permissions()->attach($permission);

                \Illuminate\Support\Facades\Gate::define($permission->name, fn () => true);
            }
        }

        return $user;
    }
}
