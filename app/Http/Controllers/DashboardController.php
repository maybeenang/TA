<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}



    public function index()
    {

        return redirect()->intended(route('welcome', absolute: false));

        return view('pages.dashboard');
    }

    public function welcome()
    {
        $laporanCount = $this->dashboardService->tenagaPengajarLaporanata();

        return view('pages.welcome', compact('laporanCount'));
    }
}
