<?php

namespace App\Http\Controllers\Frontend\Aws;

use App\Http\Controllers\Controller;

class AmiController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Aws/Amis/Index');
    }
}
