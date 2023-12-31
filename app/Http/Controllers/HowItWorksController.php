<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HowItWorksController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('how_it_works');
    }
}
