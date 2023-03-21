<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignKeywordResource;
use App\Models\Keyword;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class CampaignsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $domains = Keyword::query()
                          ->whereHas('order.client.accounts', static function (Builder $query) {
                              $query->where('email', auth()->user()->email);
                          })
                          ->get()
                          ->groupBy('domain')
                          ->sortKeys();

        return view('dashboard.campaigns', compact('domains'));
    }

    /**
     * @param \App\Models\Keyword $keyword
     *
     * @return \App\Http\Resources\CampaignKeywordResource
     */
    public function keyword(Keyword $keyword): CampaignKeywordResource
    {
        return new CampaignKeywordResource($keyword);
    }
}
