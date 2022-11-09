<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard.account.details');
    }
}
