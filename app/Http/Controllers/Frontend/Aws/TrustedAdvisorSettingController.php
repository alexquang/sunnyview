<?php

namespace App\Http\Controllers\Frontend\Aws;

use App\Http\Controllers\Controller;

class TrustedAdvisorSettingController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Aws/TrustedAdvisors/Settings/Index');
    }
}
