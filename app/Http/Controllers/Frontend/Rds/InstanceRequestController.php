<?php

namespace App\Http\Controllers\Frontend\Rds;

use App\Http\Controllers\Controller;

class InstanceRequestController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Rds/Instances/Requests/Index');
    }
}
