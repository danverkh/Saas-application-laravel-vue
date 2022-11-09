<?php

namespace App\Http\Controllers;

use App\Services\DataForSeo\Request as DataForSeoRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

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
            'domain' => 'required',
            'market' => 'required',
        ]);

        $limiterKey = $request->userAgent() . $request->ip();

        abort_if(RateLimiter::tooManyAttempts($limiterKey, 10), 429, 'Too many attempts');

        $key = "rankings.{$params['market']}.{$params['domain']}";

        $data = Cache::remember($key, now()->addHours(3), static function () use ($limiterKey, $client, $params) {
            RateLimiter::hit($limiterKey);

            return $client->requestType(DataForSeoRequest::TYPE_DOMAIN_SEARCH)
                          ->params($params['domain'], $params['market'])
                          ->fetch()
                          ->result();
        });

        return response()->json(['status' => 'success', 'rows' => $data]);
    }
}
