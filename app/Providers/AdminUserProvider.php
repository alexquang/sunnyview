<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

class AdminUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (!$credentials) {
            return null;
        }

        $auth = parent::retrieveByCredentials($credentials);

        if ($auth && ($auth->can('console.admin') || $auth->can('console.developer'))) {
            return $auth;
        }

        return null;
    }
}
