<?php

namespace Tests\Feature\Admin\Auth;

use Tests\AdminTestCase;

class LoginTest extends AdminTestCase
{
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk();
    }

    public function test_redirect_to_login_screen_if_unauthenticated()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_redirect_to_dashboard_if_access_login_screen_when_already_authenticated()
    {
        $response = $this->beAdmin()->get(route('admin.login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_users_can_authenticate_using_login_screen()
    {
        $user = $this->makeUser('console.admin');

        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user, $this->guard);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_normal_users_cannot_authenticate_using_login_screen()
    {
        $user = $this->makeUser();

        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertGuest($this->guard);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_users_cannot_authenticate_with_invalid_password()
    {
        $user = $this->makeUser('console.admin');

        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $this->assertGuest($this->guard);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_normal_users_cannot_authenticate_with_invalid_password()
    {
        $user = $this->makeUser();

        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
        $this->assertGuest($this->guard);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_admin_users_can_logout()
    {
        $response = $this->beAdmin()->post(route('admin.logout'));

        $this->assertGuest($this->guard);

        $response->assertRedirect(route('admin.login'));
    }
}
