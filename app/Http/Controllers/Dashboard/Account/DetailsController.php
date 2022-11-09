<?php

namespace App\Http\Controllers\Dashboard\Account;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DetailsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return view('dashboard.account', [
            'page'  => 'details',
            'title' => 'Details',
        ]);
    }
}
