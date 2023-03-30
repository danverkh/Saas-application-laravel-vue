<?php

namespace App\Services;

use App\Services\DataForSeo\Request as DataForSeoRequest;
use DOMDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RelevanceCalculator
{
    protected int $weight    = 0;
    protected int $maxWeight = 50 + 50 + 20 + 60 + 100 + 125 + 50;

    /**
     * @param $rank
     *
     * @return void
     */
    public function rank($rank): void
    {
        $this->weight += (100 - min((int)$rank, 100)) / 2;
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
            $this->weight += Cache::remember("relevance_score.{$keyword}.{$url}", now()->addWeek(), static function () use ($url, $keyword) {
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

        $this->weight += Cache::remember($key, now()->addWeek(), static function () use ($domain, $market, $keyword) {
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
    public function prioritizeDomainTitleAndDescription(mixed $keyword, string $domain): void
    {
        $key = "relevance_score.{$domain}.title_and_description";

        $relevantWords = Cache::remember($key, now()->addWeek(), static function () use ($domain) {
            return Domain::getRelevantWordsFromTitleAndDescription($domain);
        });

        $count = collect($relevantWords)
            ->reduce(static function (int $carry, string $word) use ($keyword) {
                return $carry + Str::substrCount($keyword, $word);
            }, 0);

        $this->weight += match ($count) {
            0 => 0,
            1 => 85,
            2 => 95,
            default => 100,
        };
    }

    /**
     * @param string $keyword
     * @param string $domain
     *
     * @return void
     */
    public function prioritizeByInternalLinks(string $keyword, string $domain): void
    {
        $key = "relevance_score.{$domain}.internal_links";

        $links = Cache::remember($key, now()->addWeek(), static function () use ($domain) {
            return Domain::getInternalLinks($domain);
        });

        $links = collect($links)
            ->map(static fn($link) => Str::replace('https://' . $domain, '', $link))
            ->map(static fn($link) => Str::substr($link, 1))
            ->map(static fn($link) => Str::beforeLast($link, '/'))
            ->map(static fn($link) => Str::beforeLast($link, '?'));

        // try to find the same keyword (words order is ignored)
        // otherwise find word with at least one word from keyword
        $link = $links->first(static fn($link) => Str::containsAll($link, explode(' ', $keyword), true))
            ?? $links->first(static fn($link) => Str::contains($link, explode(' ', $keyword, true)));

        if (!$link) {
            return;
        }

        // slashes count
        $this->weight += match (Str::substrCount($link, '/')) {
            0 => 25,
            1 => 10,
            default => 0,
        };

        // word separator count
        $this->weight += match (Str::substrCount($link, '_') + Str::substrCount($link, '-')) {
            0 => 25,
            1 => 15,
            2 => 5,
            default => 0,
        };

        // check url words with keyword
        $words = Str::replace(['/', '-', '_'], ' ', $link);
        $words = explode(' ', $words);

        // give more weight if link is "first level subpage"
        $isFirstLevelSubpage = !Str::contains($link, '/');

        if (Str::containsAll($keyword, $words)) {
            $this->weight += $isFirstLevelSubpage ? 75 : 50;
        } else {
            $count = collect($words)->reduce(static fn($carry, $word) => $carry + Str::substrCount($keyword, $word), 0);

            $this->weight += match ($count) {
                1 => $isFirstLevelSubpage ? 15 : 10,
                2 => $isFirstLevelSubpage ? 30 : 20,
                3 => $isFirstLevelSubpage ? 45 : 30,
                default => 0,
            };
        }

    }

    /**
     * @param mixed  $keyword
     * @param mixed  $domain
     * @param string $market
     *
     * @return void
     */
    public function prioritizeByRakeKeywords(mixed $keyword, mixed $domain, string $market): void
    {
        $key = "relevance_score.{$domain}.rake_keywords";

        $keywords = Cache::remember($key, now()->addWeek(), static function () use ($market, $domain) {
            $locale = match ($market) {
                'at', 'de', 'ch' => 'de_DE',
                'uk' => 'en_US',
                'fr' => 'fr_FR',
                'it' => 'it_IT',
                'es' => 'es_AR',
            };
            return Domain::contentKeywordsWithScores($domain, $locale);
        });

        $keywords = collect($keywords)
            ->reject(static fn($_, $keyword) => strlen($keyword) < 10 || strlen($keyword) > 50)
            ->filter(static fn($score) => $score > 20)
            ->keys()
            ->map(static fn($keyword) => preg_replace('/\s+/', ' ', $keyword));

        // try to find the same keyword (words order is ignored)
        // otherwise find word with at least one word from keyword
        $foundKeyword = $keywords->first(static fn($word) => Str::containsAll($word, explode(' ', $keyword), true))
            ?? $keywords->first(static fn($word) => Str::contains($word, explode(' ', $keyword, true)));

        if (!$foundKeyword) {
            return;
        }

        $words = explode(' ', $foundKeyword);

        if (Str::containsAll($keyword, $words)) {
            $this->weight += 50;
        } else {
            $count = collect($words)->reduce(static fn($carry, $word) => $carry + Str::substrCount($keyword, $word), 0);

            $this->weight += match ($count) {
                1 => 10,
                2 => 20,
                3 => 30,
                default => 0,
            };
        }
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return round(($this->weight / $this->maxWeight) * 100);
    }
}
