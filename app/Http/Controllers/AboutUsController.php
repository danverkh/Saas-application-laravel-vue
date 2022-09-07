<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AboutUsController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('about_us');
    }
}
