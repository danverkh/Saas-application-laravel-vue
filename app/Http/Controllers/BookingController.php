<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * @param string $market
     * @param string $domain
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(string $market, string $domain): View|RedirectResponse
    {
        if (Str::contains($domain, ['http', '/'])) {
            $domain = parse_url($domain, PHP_URL_HOST);
            $domain = Str::replace('www.', '', $domain);

            return redirect()
                ->route('booking', [
                    'market' => $market,
                    'query'  => $domain,
                ]);
        }
        return view('booking', compact('market', 'domain'));
    }
}
