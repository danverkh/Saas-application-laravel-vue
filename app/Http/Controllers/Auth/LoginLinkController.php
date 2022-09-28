<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginLinkController extends Controller
{
    /**
     * @param string $hash
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(string $hash): View
    {
        $user = User::firstWhere('login_hash', $hash);

        if ($user) {
            Auth::guard('web')->loginUsingId($user->id);

            request()->session()->regenerate();

            return view('auth.login_link', ['success' => true]);
        }

        return view('auth.login_link', ['success' => false]);
    }
}
