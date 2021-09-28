<?php

namespace App\Http\Controllers\Frontend\Aws;

use App\Http\Controllers\Controller;

class ElasticLoadBalancerController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Aws/Elbs/Index');
    }
}
