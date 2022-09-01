<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @param string $query
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(string $query): View
    {
        return view('booking', compact('query'));
    }
}
