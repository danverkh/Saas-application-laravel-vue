<?php

namespace App\Services;

use App\Services\DataForSeo\Request as DataForSeoRequest;
use DOMDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RelevanceCalculator
{
    protected int $score    = 0;
    protected int $maxScore = 50 + 50 + 20 + 60 + 100;

    /**
     * @param $rank
     *
     * @return void
     */
    public function rank($rank): void
    {
        $this->score += (100 - min((int)$rank, 100)) / 2;
    }

    /**
     * @param string $keyword
     * @param string $url
     *
     * @return void
     */
    public function pageContent(string $keyword, string $url): void
    {
        try {
            $this->score += Cache::remember("relevance_score.{$keyword}.{$url}", now()->addWeek(), static function () use ($url, $keyword) {
                $pageBody = Domain::getPageBody($url);

                $count     = Str::substrCount($pageBody, $keyword);
                $tempScore = min($count * 5, 50);

                // Load HTML to DOM object
                $dom = new DOMDocument();
                @$dom->loadHTML($pageBody);
                $nodes = $dom->getElementsByTagName('title');
                $title = $nodes->item(0)->nodeValue;

                $tempScore += Str::contains($title, $keyword) ? 20 : 0;

                return $tempScore;
            });
        } catch (\Throwable $e) {
            Log::debug('Failed to fetch url when calculating score', ['url' => $url, 'error' => $e->getMessage()]);
        }
    }

    /**
     * @param mixed  $keyword
     * @param string $domain
     * @param string $market
     *
     * @return void
     */
    public function keywordExistsInList(mixed $keyword, string $domain, string $market): void
    {
        $key = "relevance_score.{$domain}.{$market}";

        $this->score += Cache::remember($key, now()->addWeek(), static function () use ($domain, $market, $keyword) {
            $data = app(DataForSeoRequest::class)
                ->request(DataForSeoRequest::GOOGLE_ADS_KEYWORDS_FOR_SITE)
                ->params(['target' => $domain], $market)
                ->fetch()
                ->rawFirstResult();

            return collect($data)->pluck('keyword')->contains($keyword) ? 60 : 0;
        });
    }

    /**
     * @param mixed  $keyword
     * @param string $domain
     *
     * @return void
     */
    public function prioritizeDomainDescriptionWords(mixed $keyword, string $domain): void
    {
        $key = "relevance_score.{$domain}.title_and_description";

        $relevantWords = Cache::remember($key, now()->addWeek(), static function () use ($domain) {
            return Domain::getRelevantWordsFromTitleAndDescription($domain);
        });

        $count = collect($relevantWords)
            ->reduce(static function (int $carry, string $word) use ($keyword) {
                return $carry + Str::substrCount($keyword, $word);
            }, 0);

        $this->score += match ($count) {
            0 => 0,
            1 => 85,
            2 => 95,
            default => 100,
        };
    }

    /**
     * @param string $domain
     *
     * @return void
     */
    public function prioritizeByInternalLinks(string $domain): void
    {
        $key = "relevance_score.{$domain}.internal_links";

        $links = Cache::remember($key, now()->addWeek(), static function () use ($domain) {
            return Domain::getInternalLinks($domain);
        });

        $links = collect($links)
            ->map(static fn($link) => Str::replace('https://'.$domain, '', $link))
            ->reject(static fn($link) => strlen($link) < 4)
            ->map(static fn($link) => Str::substr($link, 1))
            ->toArray();

        dd($links);
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return round(($this->score / $this->maxScore) * 100);
    }
}
