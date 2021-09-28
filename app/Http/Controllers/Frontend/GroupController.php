<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Groups/Index');
    }
}
