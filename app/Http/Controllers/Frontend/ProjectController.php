<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Projects/Index');
    }
}
