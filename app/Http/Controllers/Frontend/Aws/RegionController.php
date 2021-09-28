<?php

namespace App\Http\Controllers\Frontend\Aws;

use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Aws/Regions/Index');
    }
}
