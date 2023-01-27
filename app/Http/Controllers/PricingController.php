<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PricingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('pricing');
    }
}
