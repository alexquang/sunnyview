<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyUserRequest;
use App\Models\AuthUser;
use App\Models\Company;
use App\Services\AuthRoleService;
use App\Services\AuthUserService;
use App\Services\GroupService;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    const SCOPES = ['enabled', 'published'];

    /**
     * @var AuthUserService
     */
    private $authUserService;

    public function __construct(AuthUserService $authUserService)
    {
        $this->authUserService = $authUserService;
    }

    public function index(Company $company)
    {
        $users = $this->authUserService->listByCompany($company);

        return \Inertia::render('Admin/Companies/_tabs/Users', compact(
            'company',
            'users'
        ));
    }

    public function create(Company $company)
    {
        /**
         * @var GroupService
         */
        $groupService = app(GroupService::class);
        $groups = $groupService->listByCompany($company, ['id', 'name']);

        /**
         * @var AuthRoleService
         */
        $roleService = app(AuthRoleService::class);
        $roles = $roleService->withScopes(self::SCOPES)->list(['id', 'name']);

        $user = new AuthUser(['is_enabled' => true]);
        $attachedRoles = [];

        return \Inertia::render('Admin/Companies/Users/Form', compact(
            'company',
            'user',
            'groups',
            'roles',
            'attachedRoles',
        ));
    }

    public function store(Company $company, CompanyUserRequest $request)
    {
        $user = $request->input('company.user', []);
        $user['company_id'] = $company->id;
        $user = $this->authUserService->create($user);

        $roleIds = $request->input('roleIds', []);
        $this->authUserService->syncRoles($user, $roleIds);

        return redirect(route('admin.companies.users.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }

    public function edit(Company $company, AuthUser $user)
    {
        /**
         * @var GroupService
         */
        $groupService = app(GroupService::class);
        $groups = $groupService->listByCompany($company, ['id', 'name']);

        /**
         * @var AuthRoleService
         */
        $roleService = app(AuthRoleService::class);
        $roles = $roleService->withScopes(self::SCOPES)->list(['id', 'name']);

        $attachedRoles = $roleService->listAssignedByUser($user, ['id', 'name']);

        return \Inertia::render('Admin/Companies/Users/Form', compact(
            'company',
            'user',
            'groups',
            'roles',
            'attachedRoles'
        ));
    }

    public function update(Company $company, AuthUser $user, CompanyUserRequest $request)
    {
        $user = $this->authUserService->update($user, $request->input('company.user', []));

        $this->authUserService->syncRoles($user, $request->input('roleIds', []));

        return redirect(route('admin.companies.users.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function enabled(Company $company, AuthUser $user)
    {
        // Change status
        $user = $this->authUserService->update($user, ['is_enabled' => !$user->is_enabled]);

        return redirect(route('admin.companies.users.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function destroy(Company $company, AuthUser $user)
    {
        $this->authUserService->delete($user);

        return redirect(route('admin.companies.users.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }
}
