<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CompanySettingService;

class SettingController extends Controller
{
    public function __construct(CompanySettingService $companySettingService)
    {
        $this->companySettingService = $companySettingService;
    }
    public function index()
    {
        // $settings = $this->companySettingService->listSettings(\Auth::user()->company);

        return \Inertia::render('Frontend/Settings/Index');
    }
}
