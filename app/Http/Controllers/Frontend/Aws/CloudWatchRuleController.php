<?php

namespace App\Http\Controllers\Frontend\Aws;

use App\Http\Controllers\Controller;

class CloudWatchRuleController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Aws/CloudWatches/Rules/Index');
    }
}
