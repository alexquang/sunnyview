<?php

namespace App\Http\Controllers\Frontend\Aws;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Aws/Accounts/Index');
    }
}
