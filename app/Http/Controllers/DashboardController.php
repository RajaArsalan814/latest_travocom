<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Dashboard';
        $menu = 'Dashboard';
        $submenu = 'list';
        // dd('sd');
        // return view('dashboard.dashboardv1')->with(compact('title', 'menu', 'submenu'));
    }
    public function sales_dashboard()
    {
        $title = 'Dashboard Sales';
        $menu = 'Dashboard';
        $submenu = 'list';

        return view('dashboard.dashboardv2')->with(compact('title', 'menu', 'submenu'));
    }
}
