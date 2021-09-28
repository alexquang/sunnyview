<?php

namespace Database\Seeders;

use App\Models\AuthPermission;
use Illuminate\Database\Seeder;

class AuthPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pemissions = array_map(function ($permission) {
            $permission['id'] = (int) $permission['id'];
            $permission['is_premium_feature'] = filter_var($permission['is_premium_feature'], FILTER_VALIDATE_BOOLEAN);
            $permission['is_developer_feature'] = filter_var($permission['is_developer_feature'], FILTER_VALIDATE_BOOLEAN);
            $permission['is_scopeable_to_group'] = filter_var($permission['is_scopeable_to_group'], FILTER_VALIDATE_BOOLEAN);
            $permission['is_scopeable_to_project'] = filter_var($permission['is_scopeable_to_project'], FILTER_VALIDATE_BOOLEAN);
            $permission['is_scopeable_to_self'] = filter_var($permission['is_scopeable_to_self'], FILTER_VALIDATE_BOOLEAN);

            return $permission;
        }, csv_to_array(base_path('permissions.csv')));

        \DB::transaction(function () use ($pemissions) {
            AuthPermission::truncate();
            AuthPermission::insert($pemissions);
        });
    }
}
