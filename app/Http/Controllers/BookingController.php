<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BookingController extends Controller
{
    /**
     * @param string $market
     * @param string $query
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(string $market, string $query): View
    {
        return view('booking', compact('market', 'query'));
    }
}
