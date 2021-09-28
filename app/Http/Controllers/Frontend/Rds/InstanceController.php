<?php

namespace App\Http\Controllers\Frontend\Rds;

use App\Http\Controllers\Controller;

class InstanceController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Rds/Instances/Index');
    }
}
