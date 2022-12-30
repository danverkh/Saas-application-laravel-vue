<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreviewRankRequest;
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
     * @param \App\Http\Requests\PreviewRankRequest $request
     * @param DataForSeoRequest                     $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PreviewRankRequest $request, DataForSeoRequest $client): JsonResponse
    {
        $params = $request->validated();

        try {
            $key = "preview-rank.{$params['market']}.{$params['keyword']}";

            $data = Cache::remember($key, now()->addHours(6), static function () use ($client, $params) {
                return $client->request(DataForSeoRequest::GOOGLE_KEYWORD_ADVANCED)
                              ->params(['keyword' => $params['keyword']], $params['market'])
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
