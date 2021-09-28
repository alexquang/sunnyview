<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Logs/Index');
    }
}
