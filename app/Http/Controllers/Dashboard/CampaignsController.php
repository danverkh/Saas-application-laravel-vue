<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class CampaignsController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $keyword = Keyword::query()
                          ->whereHas('order.client.accounts', static function (Builder $query) {
                              $query->where('email', auth()->user()->email);
                          })
                          ->orderBy('domain')
                          ->orderBy('keyword')
                          ->first();

        return redirect()->route('dashboard.campaigns.keyword', $keyword);
    }

    /**
     * @param \App\Models\Keyword $keyword
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function keyword(Keyword $keyword): View
    {
        $domains = Keyword::query()
                          ->whereHas('order.client.accounts', static function (Builder $query) {
                              $query->where('email', auth()->user()->email);
                          })
                          ->get()
                          ->groupBy('domain')
                          ->sortKeys();

        return view('dashboard.campaigns', compact('domains', 'keyword'));
    }
}
