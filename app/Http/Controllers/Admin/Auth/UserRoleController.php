<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\AuthRole;
use App\Services\AuthRoleService;
use App\Http\Controllers\Controller;
use App\Models\AuthUser;
use App\Services\AuthUserService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    const SCOPES = ['enabled'];

    /**
     * @var AuthRoleService
     */
    private $authRoleService;

    public function __construct(AuthRoleService $authRoleService)
    {
        $this->authRoleService = $authRoleService;
    }

    public function index(AuthUser $user)
    {
        $attachRoles = $this->authRoleService->listAssignedByUser(
            $user,
            ['id', 'name', 'description']
        );

        return \Inertia::render('Admin/Auth/Users/_tabs/Roles', compact(
            'user',
            'attachRoles'
        ));
    }

    public function attachForm(AuthUser $user)
    {
        $roles = $this->authRoleService
            ->withScopes(self::SCOPES)
            ->listUnAssignedByUser(
                $user,
                ['id', 'name', 'description']
            )
            ->sortBy('name')
            ->values();

        return \Inertia::render('Admin/Auth/Users/Roles/Attach', compact(
            'user',
            'roles'
        ));
    }

    public function attachRoles(AuthUser $user, Request $request)
    {
        $roleIds = $this->authRoleService
            ->withScopes(self::SCOPES)
            ->listByIds($request->input('roleIds', []), ['id'])
            ->pluck('id')
            ->toArray();
        if ($roleIds) {
            /**
             * @var AuthUserService
             */
            $authUserService = app(AuthUserService::class);

            $authUserService->attachRoles($user, $roleIds);
        }

        return redirect(route('admin.auth.users.show', $user))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function detachRoles(AuthUser $user, Request $request)
    {
        if ($roleIds = $request->input('roleIds', [])) {
            /**
             * @var AuthUserService
             */
            $authUserService = app(AuthUserService::class);

            $authUserService->detachRoles($user, $roleIds);
        }

        return redirect(route('admin.auth.users.show', $user))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }
}
