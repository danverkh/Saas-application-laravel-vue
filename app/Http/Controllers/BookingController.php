<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        return view('booking', [
            'market'   => $market,
            'query'    => $query,
            'isDomain' => isDomainName($query),
        ]);
    }
}
