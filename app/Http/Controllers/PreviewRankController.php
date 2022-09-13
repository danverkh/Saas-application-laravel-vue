<?php

namespace App\Http\Controllers;

use App\Services\DataForSeo\Request as DataForSeoRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PreviewRankController extends Controller
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
            'keyword' => 'required',
            'market'  => 'required',
            'domain'  => 'required',
        ]);

        try {
            $key = "preview-rank.{$params['market']}.{$params['keyword']}";

            $data = Cache::remember($key, now()->addHours(3), static function () use ($client, $params) {
                return $client->requestType(DataForSeoRequest::TYPE_GOOGLE_KEYWORD)
                              ->params($params['keyword'], $params['market'])
                              ->fetch()
                              ->result(['domain' => $params['domain']]);
            });
        } catch (Exception $e) {
            Log::error('Failed to preview rank: ' . $e, $params);

            return response()->json(['status' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
