<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class StaticPageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function imprint(): View
    {
        return view('imprint');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function dataPrivacy(): View
    {
        return view('data_privacy');
    }
}
