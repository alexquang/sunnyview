<?php

namespace App\Traits;

use App\Models\AuthPermission;

trait AuthPermissionAssignable
{
    public function permissions()
    {
        return $this->morphToMany(AuthPermission::class, 'assignable', 'auth_assigned_permissions')
            ->select([
                'auth_permissions.*',
                'auth_assigned_permissions.assigned_rule',
                'auth_assigned_permissions.assigned_scope'
            ]);
    }
}
