<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.index');
    }
    public function daily()
    {
        return view('dashboard.reports.daily');
    }
    public function monthly()
    {
        return view('dashboard.reports.monthly');
    }
    public function yearly()
    {
        return view('dashboard.reports.yearly');
    }
}
