<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard.reports');
    }
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
