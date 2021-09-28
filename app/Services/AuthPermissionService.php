<?php

namespace App\Services;

use App\Models\AuthRole;
use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Collection;

class AuthPermissionService extends EloquentModelService
{
    public function listAttachedByRole(AuthRole $authRole, array $columns = ['*']): Collection
    {
        return $this->listUsing(
            $authRole->permissions(),
            $columns
        );
    }

    public function listUnAttachedByRole(AuthRole $authRole, array $columns = ['*']): Collection
    {
        $attachedRoleIds = $this->listAttachedByRole($authRole, ['id'])->pluck('id')->toArray();

        return $this->listUsing(
            $this->makeQuery()->whereNotIn('id', $attachedRoleIds),
            $columns
        );
    }

    public function listUnAttachedByUser(AuthUser $user, array $columns = ['*']): Collection
    {
        $attachedPermissionIds = $user->permissions()->pluck('id')->toArray();

        return $this->listUsing(
            $this->makeQuery()->whereNotIn('id', $attachedPermissionIds),
            $columns
        );
    }

    public function listAssignedByUser(AuthUser $user, array $columns = ['*']): Collection
    {
        return $user->permissions()->get($columns);
    }
}
