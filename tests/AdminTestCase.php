<?php

namespace Tests;

abstract class AdminTestCase extends TestCase
{
    /**
     * @var string default guard to use in admin features
     */
    protected $guard = 'admin';

    /**
     * Login as admin user
     */
    protected function beAdmin(string|array $permissions = [], array $overrides = [])
    {
        $permissions = array_unique(
            array_merge(['console.admin'], \Arr::wrap($permissions ?: null))
        );

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable
         */
        $user = $this->makeUser($permissions, $overrides);

        return tap($this->be($user, $this->guard), fn () => $this->assertAuthenticated($this->guard));
    }
}
