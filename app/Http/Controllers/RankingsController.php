<?php

namespace App\Http\Controllers;

use App\Services\DataForSeoService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        try {
            $data = $client->fetch($params['query'], $params['market']);
        } catch (Exception $e) {
            Log::error('Failed to fetch rankings: ' . $e, $params);

            return response()->json(['status' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['status' => 'success', 'rows' => $data]);
    }
}
