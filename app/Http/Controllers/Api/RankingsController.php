<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class RankingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param DataForSeoRequest        $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, DataForSeoRequest $client): JsonResponse
    {
        $params = $request->validate([
            'domain'    => 'required',
            'market'    => 'required',
            'assistant' => 'sometimes|in:conversions,branding,find_employees',
        ]);

        $limiterKey = $request->userAgent() . $request->ip();

        abort_if(RateLimiter::tooManyAttempts($limiterKey, 10), 429, 'Too many attempts');

        $key = "rankings.{$params['market']}.{$params['domain']}";

        $data = Cache::remember($key, now()->addHours(3), static function () use ($limiterKey, $client, $params) {
            RateLimiter::hit($limiterKey);

            $data = $client->requestType(DataForSeoRequest::TYPE_DOMAIN_SEARCH)
                           ->params(['domain' => $params['domain']], $params['market'])
                           ->fetch()
                           ->result(['assistant' => $params['assistant'] ?? null]);

            $keywords = collect($data)->pluck('keyword')->toArray();

            $keywordSearches = $client->requestType(DataForSeoRequest::TYPE_GOOGLE_ADS_SEARCH_VOLUME)
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

        return response()->json(['status' => 'success', 'rows' => $data]);
    }
}
