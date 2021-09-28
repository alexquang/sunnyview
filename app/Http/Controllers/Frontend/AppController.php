<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Apps');
    }
}
