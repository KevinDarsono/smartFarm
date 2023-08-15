<?php

namespace App\Http\Controllers;

use App\Models\Land;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard')->with('users', (new \App\Models\User)->count());
    }

    public function farmerHome()
    {
        $land_count = Land::where('user_id', auth()->user()->id)->count();
        $device_count = Land::where('user_id', auth()->user()->id)->count();
        return view('layouts.farmer.home', compact('land_count', 'device_count'));
    }
}
