<?php

namespace App\Http\Controllers;

use App\Http\Resources\RankingsResource;
use App\Services\DataForSeoService;
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
     * @param \Illuminate\Http\Request        $request
     * @param \App\Services\DataForSeoService $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, DataForSeoService $client): JsonResponse
    {
        $params = $request->validate([
            'query'  => 'required',
            'market' => 'required',
        ]);

        $limiterKey = $request->userAgent() . $request->ip();

        abort_if(RateLimiter::tooManyAttempts($limiterKey, 10), 429, 'Too many attempts');

        try {
            $key = "rankings.{$params['market']}.{$params['query']}";

            $data = Cache::remember($key, now()->addMinutes(30), static function () use ($limiterKey, $client, $params) {
                RateLimiter::hit($limiterKey);

                return $client->fetch($params['query'], $params['market'])->getItems();
            });
        } catch (Exception $e) {
            Log::error('Failed to fetch rankings: ' . $e, $params);

            return response()->json(['status' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['status' => 'success', 'rows' => RankingsResource::collection($data)]);
    }
}
