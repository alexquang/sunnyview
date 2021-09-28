<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        return \Inertia::render('Admin/Faqs/Index');
    }
}
