<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('dashboard.account', [
            'user' => auth()->user(),
        ]);
    }
}
