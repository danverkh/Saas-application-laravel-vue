<?php

namespace App\Http\Controllers;

use App\Services\DataForSeoService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PreviewRankController extends Controller
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
            'keywords' => 'required',
            'market'   => 'required',
        ]);

        try {
            $key = "preview-rank.{$params['market']}.{$params['domain']}";

            $data = Cache::remember($key, now()->addHours(3), static function () use ($client, $params) {
                return $client->fetch($params['domain'], $params['market']);
            });
        } catch (Exception $e) {
            Log::error('Failed to preview rank: ' . $e, $params);

            return response()->json(['status' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
