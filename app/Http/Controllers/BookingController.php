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
        if (Str::contains($domain, ['http', '/', '2%F'])) {
            $domain = parse_url($domain, PHP_URL_HOST);
            $domain = Str::replace('www.', '', $domain);

            $params = [
                'market' => $market,
                'query'  => $domain,
            ];

            if (request()->has('assistant')) {
                $params['assistant'] = request('assistant');
            }
            return redirect()->route('booking', $params);
        }
        return view('booking', compact('market', 'domain'));
    }
}
