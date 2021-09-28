<?php

namespace App\Http\Controllers\Admin\Aws;

use App\Http\Controllers\Controller;
use App\Http\Requests\Aws\AccountRequest;
use App\Models\AwsAccount;
use App\Services\AwsAccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @var AwsAccountService
     */
    private $awsAcccountService;

    public function __construct(AwsAccountService $awsAcccountService)
    {
        $this->awsAcccountService = $awsAcccountService;
    }

    public function index()
    {
        $accounts = $this->awsAcccountService->list();

        return \Inertia::render('Admin/Aws/Accounts/Index', compact('accounts'));
    }

    public function create(Request $request)
    {
        $account = new AwsAccount([
            'external_id' => \Str::uuid()->toString(),
        ]);

        $iamRoleCreationLink = $this->generateIAMRoleCreationLink($account->external_id);

        return \Inertia::render('Admin/Aws/Accounts/Form', compact(
            'account',
            'iamRoleCreationLink'
        ));
    }

    public function store(AccountRequest $request)
    {
        $this->awsAcccountService->create($request->input('aws.account', []));

        return redirect(route('admin.aws.accounts.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }

    public function edit(AwsAccount $account)
    {
        $iamRoleCreationLink = $this->generateIAMRoleCreationLink($account->external_id);

        return \Inertia::render('Admin/Aws/Accounts/Form', compact(
            'account',
            'iamRoleCreationLink'
        ));
    }

    public function update(AwsAccount $account, AccountRequest $request)
    {
        $this->awsAcccountService->update($account, $request->input('aws.account', []));

        return redirect(route('admin.aws.accounts.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function destroy(AwsAccount $account)
    {
        $this->awsAcccountService->delete($account);

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }

    private function generateIAMRoleCreationLink(string $externalId)
    {
        $params = [
            'region' => config('aws.default_region'),
            'templateURL' => config('aws.cloud_formation_template_link'),
            'stackName' => 'sunnyview-1-0',
            'param_ExternalId' => $externalId,
            'param_sunnyviewAccountId' => config('aws.master_account.id'),
            // 'param_DBRBucket' => '',
            // 'param_CURBucket' => '',
        ];

        return sprintf('%s?%s ', config('aws.cloud_formation_creation_link'), http_build_query($params));
    }
}
