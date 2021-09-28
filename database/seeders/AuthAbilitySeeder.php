<?php

namespace Database\Seeders;

use App\Models\AuthPermission;
use App\Models\AuthRole;
use App\Models\AuthUser;
use Illuminate\Database\Seeder;

class AuthAbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEmail = config('auth.super_admin_email') ?: 'admin@vn.ids.jp';

        $user = AuthUser::where('email', $adminEmail)->firstOrFail();

        $adminRole = AuthRole::where('name', 'ids-admin')->firstOrFail();

        $this->attachPermissions($adminRole, [
            'console.admin' => [
                'rule' => 'allow',
            ],
        ]);

        $user->roles()->sync([$adminRole->id]);
    }

    private function attachPermissions(AuthUser|AuthRole $assignable, array $permissions)
    {
        $authPermissions = AuthPermission::whereIn('name', array_keys($permissions))->get();
        $authPermissions = $authPermissions->map(function ($permission) use ($permissions) {
            return [
                'auth_permission_id' => $permission->id,
                'assigned_rule' => $permissions[$permission->name]['rule'],
                'assigned_scope' => $permissions[$permission->name]['scope'] ?? null,
            ];
        })
            ->keyBy('auth_permission_id')
            ->toArray();

        $assignable->permissions()->sync($authPermissions);

        return $assignable;
    }
}
