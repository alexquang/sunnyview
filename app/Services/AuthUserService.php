<?php

namespace App\Services;

use App\Models\AuthRole;
use App\Models\AuthUser;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AuthUserService extends EloquentModelService
{
    public function create(array $data): AuthUser
    {
        $user = new AuthUser();
        $user->fill($data);
        // Encrypt password
        $user->password = Hash::make($user->password);
        $user->save();

        return $user->fresh();
    }

    public function update(AuthUser $user, array $data): AuthUser
    {
        return tap($user->fresh(), fn () => $user->fill($data)->save());
    }

    public function delete(AuthUser $user)
    {
        $user->delete();

        return $user->fresh();
    }

    public function listByCompany(Company $company): Collection
    {
        return $company->users()->with([
            'group:id,name',
            'roles:id,name',
        ])->get([
            'id',
            'name',
            'email',
            'group_id',
            'login_failed_count',
            'last_logged_in_at',
            'is_enabled',
        ])->map(function ($item) {
            $item->attached_roles = $item->roles->pluck('name')->toArray();

            $item->group_info = $item->group->only('name');

            return $item;
        });
    }

    public function listAssignedByRole(AuthRole $authRole, array $columns = ['*']): Collection
    {
        return $this->listUsing($authRole->users(), $columns);
    }

    public function listUnAssignedByRole(AuthRole $authRole, array $columns = ['*']): Collection
    {
        $assignedUserIds = $this->listAssignedByRole($authRole, ['id'])->pluck('id')->toArray();

        return $this->listUsing(
            $this->makeQuery()->whereNotIn('id', $assignedUserIds),
            $columns
        );
    }

    public function attachRoles(AuthUser $user, array $roleIds): void
    {
        $roleIds = $user->roles->pluck('id')->merge($roleIds)->unique()->toArray();

        $user->roles()->sync($roleIds);
    }

    public function detachRoles(AuthUser $user, array $roleIds): void
    {
        $roleIds = $user->roles()->whereNotIn('id', $roleIds)->get()->pluck('id')->toArray();

        $user->roles()->sync($roleIds);
    }

    public function syncRoles(AuthUser $user, array $roleIds): void
    {
        $user->roles()->sync($roleIds);
    }

    public function attachPermissions(AuthUser $user, array $permissions): void
    {
        $assignedPermissions = $user
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

        $user->permissions()->sync($permissions);
    }

    public function detachPermissions(AuthUser $user, array $permissionIds = []): void
    {
        $permissions = $user->permissions()
            ->select([
                'auth_permission_id',
                'assigned_rule',
                'assigned_scope',
            ])
            ->whereNotIn('auth_permission_id', $permissionIds)
            ->get()
            ->keyBy('auth_permission_id')
            ->toArray();

        $user->permissions()->sync($permissions);
    }
}
