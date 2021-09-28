<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyGroupRequest;
use App\Models\Company;
use App\Models\Group;
use App\Services\GroupService;
use Carbon\Carbon;

class CompanyGroupController extends Controller
{
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index(Company $company)
    {
        $groups = $this->groupService->withCounts(['users'])->listByCompany($company);

        return \Inertia::render('Admin/Companies/_tabs/Groups', compact('company', 'groups'));
    }

    public function create(Company $company)
    {
        $group = new Group();

        return \Inertia::render('Admin/Companies/Groups/Form', compact('company', 'group'));
    }

    public function store(Company $company, CompanyGroupRequest $request)
    {
        $groupRequest = $request->input('company.group', []);
        $groupRequest['company_id'] = $company->id;

        $this->groupService->create($groupRequest);

        return redirect(route('admin.companies.groups.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }

    public function edit(Company $company, Group $group)
    {
        return \Inertia::render('Admin/Companies/Groups/Form', compact('company', 'group'));
    }

    public function update(Company $company, Group $group, CompanyGroupRequest $request)
    {
        $this->groupService->update($group, $request->input('company.group', []));

        return redirect(route('admin.companies.groups.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function destroy(Company $company, Group $group)
    {
        $this->groupService->delete($group);

        return redirect(route('admin.companies.groups.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }
}
