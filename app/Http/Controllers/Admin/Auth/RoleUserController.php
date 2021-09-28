<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\AuthRole;
use App\Services\AuthRoleService;
use App\Http\Controllers\Controller;
use App\Services\AuthUserService;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    const SCOPES = ['internal'];

    /**
     * @var AuthUserService
     */
    private $authUserService;

    public function __construct(AuthUserService $authUserService)
    {
        $this->authUserService = $authUserService;
    }

    public function index(AuthRole $role)
    {
        $assignedUsers = $this->authUserService
            ->withScopes(self::SCOPES)
            ->listAssignedByRole(
                $role,
                ['id', 'name', 'email']
            );

        return \Inertia::render('Admin/Auth/Roles/_tabs/Users', compact(
            'role',
            'assignedUsers'
        ));
    }

    public function assignForm(AuthRole $role)
    {
        $users = $this->authUserService
            ->withScopes(self::SCOPES)
            ->listUnAssignedByRole(
                $role,
                ['id', 'name', 'email']
            )
            ->sortBy('email')
            ->values();

        return \Inertia::render('Admin/Auth/Roles/Users/Assign', compact(
            'role',
            'users'
        ));
    }

    public function assign(AuthRole $role, Request $request)
    {
        $this->syncUsers($role, $request->input('userIds', []), 'assign');

        return redirect(route('admin.auth.roles.users.index', $role))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function retract(AuthRole $role, Request $request)
    {
        $this->syncUsers($role, $request->input('userIds', []), 'retract');

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    private function syncUsers(AuthRole $role, array $userIds, string $action)
    {
        $userIds = $this->authUserService
            ->withScopes(['internal'])
            ->listByIds($userIds, ['id'])
            ->pluck('id')
            ->toArray();
        if ($userIds) {
            /**
             * @var AuthRoleService
             */
            $authRoleService = app(AuthRoleService::class);

            if ($action == 'assign') {
                $authRoleService->assignUsers($role, $userIds);
            } elseif ($action == 'retract') {
                $authRoleService->retractUsers($role, $userIds);
            }
        }
    }
}
