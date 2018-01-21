<?php

namespace App\Http\Controllers;

use App\Http\ViewObjects\Dashboard;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboard = app(Dashboard::class)->getDashboard();
        $accounts = $dashboard->platform->platforms;
        $portfolio = $dashboard->portfolio;

        return view('dashboard.index', compact('accounts', 'portfolio'));
    }
}
