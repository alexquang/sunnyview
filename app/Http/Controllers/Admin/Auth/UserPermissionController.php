<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PermissionAttachRequest;
use App\Models\AuthUser;
use App\Services\AuthPermissionService;
use App\Services\AuthUserService;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    const SCOPES = ['enabled'];

    /**
     * @var AuthPermissionService
     */
    private $authPermissionService;

    public function __construct(AuthPermissionService $authPermissionService)
    {
        $this->authPermissionService = $authPermissionService;
    }

    public function index(AuthUser $user)
    {
        $attachPermissions = $this->authPermissionService->listAssignedByUser(
            $user,
            ['id', 'name', 'assigned_rule', 'assigned_scope']
        );
        return \Inertia::render('Admin/Auth/Users/_tabs/Permissions', compact(
            'user',
            'attachPermissions'
        ));
    }

    public function attachForm(AuthUser $user)
    {
        $permissions = $this->authPermissionService
            ->withScopes(self::SCOPES)
            ->listUnAttachedByUser(
                $user,
                ['id', 'name', 'description']
            );

        return \Inertia::render('Admin/Auth/Users/Permissions/Attach', compact(
            'user',
            'permissions'
        ));
    }

    public function attachPermissions(AuthUser $user, PermissionAttachRequest $request)
    {
        $permissions = collect($request->input('permissions', []))->where('selected', true);

        if ($permissions->count()) {

            $permissionsCount = $this->authPermissionService
                ->withScopes(self::SCOPES)
                ->listByIds($permissions->pluck('id')->toArray())
                ->count();
        } else {
            $permissionsCount = 0;
        }

        if ($permissionsCount) {
            /**
             * @var AuthUserService
             */
            $authUserService = app(AuthUserService::class);
            $authUserService->attachPermissions($user, $permissions->toArray());
        }

        return redirect(route('admin.auth.users.show', $user))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function detachPermissions(AuthUser $user, Request $request)
    {
        if ($permissionIds = $request->input('permissionIds', [])) {
            /**
             * @var AuthUserService
             */
            $authUserService = app(AuthUserService::class);
            $authUserService->detachPermissions($user, $permissionIds);
        }

        return redirect(route('admin.auth.users.show', $user))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }
}
