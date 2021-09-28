<?php

namespace Database\Seeders;

use App\Models\AuthUser;
use Illuminate\Database\Seeder;

class AuthUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEmail = config('auth.super_admin_email') ?: 'admin@vn.ids.jp';

        AuthUser::where('email', '=', $adminEmail)->delete();
        AuthUser::factory([
            'company_id' => null,
            'name' => 'haivd',
            'email' => $adminEmail,
            'password' => \Hash::make(config('auth.super_admin_password') ?: 'password'),
        ])->create();
    }
}
