<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function form(): View
    {
        return view('checkout.form');
    }

    /**
     * @param \App\Http\Requests\OrderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(OrderRequest $request): JsonResponse
    {
        $order = Order::create($request->validated());

        foreach ($request->selectedItems as $keyword) {
            $order->keywords()->create($keyword);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function thankYou(): View
    {
        return view('checkout.thank_you');
    }
}
