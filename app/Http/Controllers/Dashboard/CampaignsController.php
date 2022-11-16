<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CampaignsController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $domain = Domain::query()
                        ->whereHas('orders', static function ($query) {
                            $query->where('user_id', auth()->id());
                        })
                        ->with('keywords')
                        ->orderBy('name')
                        ->firstOrFail();

        return redirect()->route('dashboard.campaigns.keyword', $domain->keywords->first());
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
