<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with(['keywords'])
                       ->get();

        return view('dashboard.campaigns', compact('orders'));
    }
}
