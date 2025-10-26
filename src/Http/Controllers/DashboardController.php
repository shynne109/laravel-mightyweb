<?php

namespace MightyWeb\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('mightyweb::dashboard');
    }
}
