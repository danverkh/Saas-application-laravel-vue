<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with(['keywords'])
                       ->get();

        dd($orders[0]->keywords->toArray());

        return view('dashboard.index', compact('orders'));
    }
}
