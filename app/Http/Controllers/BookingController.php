<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BookingController extends Controller
{
    /**
     * @param string $market
     * @param string $domain
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(string $market, string $domain): View
    {
        return view('booking', compact('market', 'domain'));
    }
}
