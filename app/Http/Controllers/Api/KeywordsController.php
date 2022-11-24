<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateKeywordRequest;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class KeywordsController extends Controller
{
    /**
     * @param \App\Http\Requests\ValidateKeywordRequest $request
     * @param \App\Services\DataForSeo\Request          $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateKeyword(ValidateKeywordRequest $request, DataForSeoRequest $client): JsonResponse
    {
        $key = "keyword-validate.{$request->keyword}.{$request->market}.{$request->domain}";

        try {
            $result = Cache::remember($key, now()->addHours(3), static function () use ($request, $client) {
                $keyword         = mb_convert_encoding($request->keyword, 'UTF-8');
                $keywordIsRanked = false;

                $items = $client->requestType(DataForSeoRequest::TYPE_GOOGLE_KEYWORD_REGULAR)
                                ->params(['keyword' => $keyword], $request->market)
                                ->fetch()
                                ->rawItems();

                $foundDomain = false;

                foreach ($items as $serpItem) {
                    if (str_contains($serpItem['url'], $request->domain)) {
                        $foundDomain = true;
                        break;
                    }
                }
                if ($foundDomain === false) {
                    return 'not_possible';
                }

                // Verify domain is _actually_ found by iterating over serp pages iteratively
                for ($i = 0; $i <= 70; $i += 10) {
                    $items = $client->requestType(DataForSeoRequest::TYPE_GOOGLE_KEYWORD_REGULAR)
                                    ->params([
                                        'keyword'      => $keyword,
                                        'search_param' => 'start=' . $i,
                                        'depth'        => 10,
                                    ], $request->market)
                                    ->fetch()
                                    ->rawItems();

                    foreach ($items as $serpItem) {
                        if (
                            // prefixes needed as sometimes domain name is part of URL of another domain
                            !str_contains($serpItem['url'], "https://" . $request->domain) &&
                            !str_contains($serpItem['url'], "http://" . $request->domain) &&
                            !str_contains($serpItem['url'], "http://www." . $request->domain) &&
                            !str_contains($serpItem['url'], "https://www." . $request->domain)
                        ) {
                            continue;
                        }
                        $keywordIsRanked = true;
                    }

                    if ($keywordIsRanked === true) {
                        break;
                    }
                }

                return $keywordIsRanked ? 'possible' : 'not_possible';
            });
        } catch (Exception $e) {
            Log::notice("An Exception (likely timeout) occurred: " . $e->getMessage());

            return response()->json(['result' => 'failed'], Response::HTTP_REQUEST_TIMEOUT);
        }

        return response()->json(
            ['result' => $result],
            ($result === 'failed') ? Response::HTTP_FAILED_DEPENDENCY : Response::HTTP_OK
        );
    }
}
