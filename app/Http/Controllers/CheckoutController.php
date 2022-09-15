<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(Request $request): JsonResponse
    {

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
