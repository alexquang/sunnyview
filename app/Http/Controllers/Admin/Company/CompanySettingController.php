<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanySettingRequest;
use App\Models\Company;
use App\Models\CompanySetting;
use App\Services\CompanySettingService;

class CompanySettingController extends Controller
{
    const SETTING_KEYS = [CompanySetting::KEY_BILLING_ALERT];

    /**
     * @var CompanySettingService
     */
    private $companySettingService;

    public function __construct(CompanySettingService $companySettingService)
    {
        $this->companySettingService = $companySettingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $settings = $this->companySettingService->listSettings($company, self::SETTING_KEYS);

        return \Inertia::render('Admin/Companies/_tabs/Settings', compact(
            'company',
            'settings'
        ));
    }

    public function update(Company $company, CompanySettingRequest $request)
    {
        $this->companySettingService->update($company, $request->input('company.settings', []));

        return redirect(route('admin.companies.settings.index', $company))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }
}
