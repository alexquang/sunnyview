<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PermissionAttachRequest;
use App\Models\AuthRole;
use App\Services\AuthPermissionService;
use App\Services\AuthRoleService;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
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

    public function index(AuthRole $role)
    {
        $attachedPermissions = $this->authPermissionService
            ->withScopes(self::SCOPES)
            ->listAttachedByRole(
                $role,
                ['id', 'name', 'assigned_rule', 'assigned_scope']
            );

        return \Inertia::render('Admin/Auth/Roles/_tabs/Permissions', compact(
            'role',
            'attachedPermissions'
        ));
    }

    public function attachForm(AuthRole $role)
    {
        $permissions = $this->authPermissionService
            ->withScopes(self::SCOPES)
            ->listUnAttachedByRole(
                $role,
                ['id', 'name', 'description']
            );

        return \Inertia::render('Admin/Auth/Roles/Permissions/Attach', compact(
            'role',
            'permissions'
        ));
    }

    public function attach(AuthRole $role, PermissionAttachRequest $request)
    {
        $permissions = collect($request->input('permissions'))->where('selected', true);

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
             * @var AuthRoleService
             */
            $authRoleService = app(AuthRoleService::class);

            $authRoleService->attachPermissions($role, $permissions->toArray());
        }

        return redirect(route('admin.auth.roles.permissions.index', $role))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function detach(AuthRole $role, Request $request)
    {
        if ($permissionIds = $request->input('permissionIds', [])) {
            /**
             * @var AuthRoleService
             */
            $authRoleService = app(AuthRoleService::class);

            $authRoleService->detachPermissions($role, $permissionIds);
        }

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }
}
