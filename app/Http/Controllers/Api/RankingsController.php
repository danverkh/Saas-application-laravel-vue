<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RankingsRequest;
use App\Models\Keyword;
use App\Models\User;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class RankingsController extends Controller
{
    /**
     * @param \App\Http\Requests\RankingsRequest $request
     * @param DataForSeoRequest                  $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RankingsRequest $request, DataForSeoRequest $client): JsonResponse
    {
        $params = $request->validated();

        $limiterKey = $request->userAgent() . $request->ip();

        abort_if(RateLimiter::tooManyAttempts($limiterKey, 10), 429, 'Too many attempts');

        $key = "rankings.{$params['market']}.{$params['domain']}";

        $data = Cache::remember($key, now()->addHours(6), static function () use ($limiterKey, $client, $params) {
            RateLimiter::hit($limiterKey);

            $data = $client->request(DataForSeoRequest::DOMAIN_SEARCH)
                           ->params(['domain' => $params['domain']], $params['market'])
                           ->fetch()
                           ->result(['assistant' => $params['assistant'] ?? null]);

            $keywords = collect($data)->pluck('keyword')->toArray();

            $keywordSearches = $client->request(DataForSeoRequest::GOOGLE_ADS_SEARCH_VOLUME)
                                      ->params(['keywords' => $keywords], $params['market'])
                                      ->fetch()
                                      ->rawResults();

            $keywordSearches = collect($keywordSearches)->keyBy('keyword');

            return collect($data)
                ->map(static function ($item) use ($keywordSearches) {
                    return [
                        ...$item,
                        'competition'      => data_get($keywordSearches[$item['keyword']], 'competition_index'),
                        'monthly_searches' => data_get($keywordSearches[$item['keyword']], 'monthly_searches', []),
                    ];
                })
                ->toArray();
        });

        $purchasedKeywords = Keyword::whereIn('order_id', User::find($request->user_id)?->client->orders->pluck('id') ?? [])
                     ->where('domain', $params['domain'])
                     ->get('keyword');

        return response()->json([
            'status'             => 'success',
            'rows'               => $data,
            'purchased_keywords' => $purchasedKeywords,
        ]);
    }
}
