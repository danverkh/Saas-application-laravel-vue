<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KeywordsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request         $request
     * @param \App\Services\DataForSeo\Request $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateKeywords(Request $request, DataForSeoRequest $client): JsonResponse
    {
        $keywords = $request->get('keywords', []);


        $client->requestType(DataForSeoRequest::TYPE_GOOGLE_KEYWORD_REGULAR)
               ->params($request->domain, $request->market, $keyword)
               ->fetch()
               ->rawItems();


        foreach ($keywords as $keyword) {
            $keywordIsRanked = false;

            // preemptive fetch for top 100 SERPs
            $postArray   = null;
            $postArray[] = [
                'location_name' => $languageByLocation[$autoRankerKeyword['country']]['location'],
                'language_name' => $languageByLocation[$autoRankerKeyword['country']]['language'],
                'keyword'       => mb_convert_encoding($keyword, 'UTF-8'),
            ];

            try {
                $result = $client->post('/v3/serp/google/organic/live/regular', $postArray);
            } catch (Exception $e) {
                Log::notice("An Exception (likely timeout) occurred: ". $e->getMessage());
                continue;
            }

            $foundDomain = false;

            foreach (data_get($result, 'tasks.0.result.0.items', []) as $serpItem) {
                if (str_contains($serpItem['url'], $domain)) {
                    $foundDomain = true;
                }
            }
            if ($foundDomain === false) {
                continue;
            }

            // Verify domain is _actually_ found by iterating over serp pages iteratively
            for ($i = 0; $i <= 70; $i += 10) {
                $postArray   = null;
                $postArray[] = [
                    'location_name' => $languageByLocation[$autoRankerKeyword['country']]['location'],
                    'language_name' => $languageByLocation[$autoRankerKeyword['country']]['language'],
                    'keyword'       => mb_convert_encoding($keyword, 'UTF-8'),
                    'search_param'  => 'start=' . $i,
                    'depth'         => 10,
                ];

                try {
                    $result = $client->post('/v3/serp/google/organic/live/regular', $postArray);
                } catch (Exception $e) {
                    Log::notice("An Exception (likely timeout) occurred: ". $e->getMessage());
                    continue;
                }

                foreach (data_get($result, 'tasks.0.result.0.items', []) as $serpItem) {
                    if (
                        // prefixes needed as sometimes domain name is part of URL of another domain
                        !str_contains($serpItem['url'], "https://" . $domain) &&
                        !str_contains($serpItem['url'], "http://" . $domain) &&
                        !str_contains($serpItem['url'], "http://www." . $domain) &&
                        !str_contains($serpItem['url'], "https://www." . $domain)
                    ) {
                        continue;
                    }

                    $keywordIsRanked = true;
                }

                if ($keywordIsRanked === true) {
                    break;
                }
            }
        }

        return response()->json([]);
    }
}
