<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $count['total'] = Order::count();
        $count['yearly'] = Order::whereYear('created_at', Carbon::now()->year)->count();
        $count['monthly'] = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $count['daily'] = Order::whereDay('created_at', Carbon::now()->day)->count();
        return view('admin.page.dashboard.index', compact('count'));
    }
}
