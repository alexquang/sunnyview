<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        \Auth::provider('eloquent_admin', function ($app, array $config) {
            return new AdminUserProvider($app['hash'], $config['model']);
        });

        if (!\App::runningInConsole()) {
            \App\Models\AuthPermission::enabled()->get()->each(function ($authPermission) {
                Gate::define($authPermission->name, function (\App\Models\AuthUser $user, $model = null) use ($authPermission) {
                    $assignedPermission = $user->listAssignedPermissions(\App::runningUnitTests())[$authPermission->name] ?? null;
                    if (!$assignedPermission || $assignedPermission['assigned_rule'] != 'allow') {
                        return false;
                    }

                    return true;
                });
            });
        };
    }
}
