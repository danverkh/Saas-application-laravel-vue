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
        $domains = Domain::query()
                         ->whereHas('orders', static function ($query) {
                             $query->where('user_id', auth()->id());
                         })
                         ->with(['keywords'])
                         ->orderBy('name')
                         ->get();

        return view('dashboard.campaigns', compact('domains', 'keyword'));
    }
}
