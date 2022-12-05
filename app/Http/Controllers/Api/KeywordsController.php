<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RelevanceKeywordRequest;
use App\Http\Requests\ValidateKeywordRequest;
use App\Services\DataForSeo\Modifiers\Actions\CalculateMissingValues;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use DOMDocument;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
            $response = Cache::remember($key, now()->addHours(3), static function () use ($request, $client) {
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

                if ($keywordIsRanked) {
                    $data = $client->requestType(DataForSeoRequest::TYPE_GOOGLE_ADS_SEARCH_VOLUME)
                                   ->params(['keywords' => [$request->keyword]], $request->market)
                                   ->fetch()
                                   ->rawResult();

                    if ($data['search_volume'] === null || $data['high_top_of_page_bid'] === null) {
                        $keywordIsRanked = false;
                    } else {
                        $data = [
                            'cpc'           => $data['high_top_of_page_bid'],
                            'search_volume' => $data['search_volume'],
                        ];

                        $data = array_merge($data, CalculateMissingValues::calculate($data));
                    }
                }

                return [
                    'result' => $keywordIsRanked ? 'possible' : 'not_possible',
                    'data'   => $data ?? null,
                ];
            });
        } catch (Exception $e) {
            Log::notice("KeywordsController: An Exception (likely timeout) occurred: " . $e->getMessage());

            return response()->json(['result' => 'failed'], Response::HTTP_FAILED_DEPENDENCY);
        }

        return response()->json(
            $response,
            ($response['result'] === 'failed') ? Response::HTTP_FAILED_DEPENDENCY : Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\RelevanceKeywordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function relevance(RelevanceKeywordRequest $request): JsonResponse
    {
        $score = 0;
        $maxScore = 99 + 30 + 20;

        // rank score
        $score += 100 - max($request->rank, 100);

        // keyword in page content
        try {
            $pageBody = Http::get($request->url)->body();
            $count = Str::wordCount($pageBody, $request->keyword);

            $score += $count * 3;

            // Load HTML to DOM object
            $dom = new DOMDocument();
            @$dom->loadHTML($pageBody);
            $nodes = $dom->getElementsByTagName('title');
            $title = $nodes->item(0)->nodeValue;

            $score += Str::wordCount($title, $request->keyword) * 20;
        } catch (\Throwable $e) {
            Log::debug('Failed to fetch url when calculating score', ['url' => $request->url, 'error' => $e->getMessage()]);
        }

        return response()->json(['percentage' => ($score/$maxScore) * 100]);
    }
}
