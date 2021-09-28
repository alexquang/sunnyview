<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return \Inertia::render('Frontend/Notifications/Index');
    }
}
