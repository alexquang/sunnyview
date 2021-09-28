<?php

namespace App\Http\Controllers\Frontend\Ec2;

use App\Http\Controllers\Controller;

class InstanceTypeController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Ec2/Instances/Types/Index');
    }
}
