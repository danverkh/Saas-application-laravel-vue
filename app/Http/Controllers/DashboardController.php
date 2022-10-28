<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function reports(): View
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with(['keywords'])
                       ->get();

        return view('dashboard.reports', compact('orders'));
    }
}
