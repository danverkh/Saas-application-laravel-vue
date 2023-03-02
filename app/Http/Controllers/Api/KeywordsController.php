<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RelevanceKeywordRequest;
use App\Http\Requests\ValidateKeywordRequest;
use App\Services\DataForSeo\Modifiers\Actions\CalculateMissingValues;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use App\Services\RelevanceCalculator;
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
            $response = Cache::remember($key, now()->addHours(3), static function () use ($request, $client) {
                $keyword         = mb_convert_encoding($request->keyword, 'UTF-8');
                $keywordIsRanked = false;

                $items = $client->request(DataForSeoRequest::GOOGLE_KEYWORD_REGULAR)
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
                    return ['result' => 'not_possible'];
                }

                // Verify domain is _actually_ found by iterating over serp pages iteratively
                for ($i = 0; $i <= 70; $i += 10) {
                    $items = $client->request(DataForSeoRequest::GOOGLE_KEYWORD_REGULAR)
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
                    $data = $client->request(DataForSeoRequest::GOOGLE_ADS_SEARCH_VOLUME)
                                   ->params(['keywords' => [$request->keyword]], $request->market)
                                   ->fetch()
                                   ->rawFirstResult();

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
        $results = collect($request->items)
            ->mapWithKeys(static function ($item) use ($request) {
                $calculator = new RelevanceCalculator();

                // 1. rank score
                $calculator->rank($item['rank']);

                // 2. keyword in page content
                $calculator->pageContent($item['keyword'], $item['url']);

                // 3. check if keyword is in the "Keywords For Site" response
                $calculator->keywordExistsInList($item['keyword'], $request->domain, $request->market);

                return [$item['keyword'] => $calculator->getResult()];
            });

        return response()->json($results);
    }
}
