<?php

namespace App\Services;

use App\Models\AuthRole;
use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Collection;

class AuthRoleService extends EloquentModelService
{
    public function create(array $data): AuthRole
    {
        $role = new AuthRole();

        return tap($role->fresh(), fn () => $role->fill($data)->save());
    }

    public function update(AuthRole $role, array $data): AuthRole
    {
        return tap($role->fresh(), fn () => $role->fill($data)->save());
    }

    public function assignUsers(AuthRole $role, array $userIds): void
    {
        $userIds = $role->users->pluck('id')->merge($userIds)->unique()->toArray();

        $role->users()->sync($userIds);
    }

    public function retractUsers(AuthRole $role, array $userIds): void
    {
        $userIds = $role->users()->whereNotIn('id', $userIds)->get()->pluck('id')->toArray();

        $role->users()->sync($userIds);
    }

    public function attachPermissions(AuthRole $role, array $permissions): void
    {
        $assignedPermissions = $role
            ->permissions()
            ->select([
                'auth_permission_id',
                'assigned_rule',
                'assigned_scope',
            ])
            ->get();

        $permissions = collect($permissions)
            ->map(function ($permission) {
                return [
                    'auth_permission_id' => \Arr::get($permission, 'id'),
                    'assigned_rule' => \Arr::get($permission, 'rule'),
                    'assigned_scope' => \Arr::get($permission, 'scope'),
                ];
            })
            ->merge($assignedPermissions)
            ->unique('auth_permission_id')
            ->keyBy('auth_permission_id')
            ->toArray();

        $role->permissions()->sync($permissions);
    }

    public function detachPermissions(AuthRole $role, array $permissionIds = []): void
    {
        $permissions = $role->permissions()
            ->select([
                'auth_permission_id',
                'assigned_rule',
                'assigned_scope',
            ])
            ->whereNotIn('auth_permission_id', $permissionIds)
            ->get()
            ->keyBy('auth_permission_id')
            ->toArray();

        $role->permissions()->sync($permissions);
    }

    public function listAssignedByUser(AuthUser $user, array $columns = ['*']): Collection
    {
        return $user->roles()->get($columns);
    }

    public function listUnAssignedByUser(AuthUser $user, array $columns = ['*']): Collection
    {
        $assignedRoleIds = $user->roles()->pluck('id')->toArray();

        return $this->listUsing(
            $this->makeQuery()->whereNotIn('id', $assignedRoleIds),
            $columns
        );
    }
}
