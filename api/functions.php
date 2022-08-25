<?php

$blockedKeywords = get_blocked_keywords();

$languageByLocation = [
    'AT' => ['location' => 'Austria', 'language' => 'German'],
    'BE' => ['location' => 'Belgium', 'language' => 'French'],
    'CH' => ['location' => 'Switzerland', 'language' => 'German'],
    'DE' => ['location' => 'Germany', 'language' => 'German'],
    'FR' => ['location' => 'France', 'language' => 'French'],
    'IT' => ['location' => 'Italy', 'language' => 'Italian'],
    'ES' => ['location' => 'Spain', 'language' => 'Spanish'],
    'UK' => ['location' => 'United Kingdom', 'language' => 'English'],
    'US' => ['location' => 'United States', 'language' => 'English'],
];

$soldKeywords = [];
$isKeywordSold = function ($keyword, $market) use ($blockedKeywords, $soldKeywords) {
    foreach ($soldKeywords as $bookedKeyword) {
        $blockedKeywords[strtoupper($bookedKeyword['country'])][] = $bookedKeyword['keyword'];
    }
    return in_array(mb_strtolower($keyword), $blockedKeywords[$market], true);
};

$eurosPerMonth = function ($searchVolume, $keyword, $market) use ($isKeywordSold) {
    if ($isKeywordSold($keyword, $market)) {
        return 0;
    }
    if ($searchVolume <= 3300) {
        return 159;
    }
    if ($searchVolume <= 13000) {
        return 289;
    }
    if ($searchVolume <= 25000) {
        return 399;
    }
    return 0;
};

$factor = function($cpc) {
    if ($cpc < 3) {
        $cpc = 3;
    }
    if ($cpc > 15) {
        $cpc = 15;
    }
    return $cpc;
};

$apiMap2Frontend = fn($data, $market, $allBlockedKeywords) => [
    'keyword' => $data['keyword'],
    'price' => in_array($data['raw_keyword'] ?? $data['keyword'],  [], true) ? 0 : $eurosPerMonth($data['search_volume'] * $factor($data['cpc']), $data['keyword'], $market)
];

$result2Frontend = function ($result, $market, $allBlockedKeywords) use ($apiMap2Frontend) {
    $returnArray = array_map(fn($result) => $apiMap2Frontend($result, $market, $allBlockedKeywords), $result);
    return $returnArray;
};

$postArrayKeywords = fn($market, $keyword) => [[
    'location_name' => $languageByLocation[$market]['location'],
    'language_name' => $languageByLocation[$market]['language'],
    'keywords' => $keyword
]];

$resultKeywordsVolume = function ($result) {
    $DATE_OF_CHANGE = strtotime('2022-01-25');
    $days_since_the_change = ceil((time() - $DATE_OF_CHANGE) / 86400);

    $returnArray = array_map(fn($result) => [
        'keyword' => $result['keyword'],
        'volume' => (($result['search_volume']) + ($result['search_volume'] * 2.94 * ($days_since_the_change / 30))),
        'tendency' => strlen($result['keyword']) * (time() / 86400 / 7) % 5
    ], $result);
    return $returnArray;
};


function idn_host_to_ascii(string $url): string
{
    $urlArray = parse_url($url);

    // no scheme available? e.g. just "demouser.de" => add scheme
    if (!\array_key_exists('scheme', $urlArray)) {
        $urlArray = parse_url('http://' . $url);
    }

    if ($urlArray === false) {
        return $url;
    }

    if (!\array_key_exists('host', $urlArray)) {
        return $url;
    }

    $originalHost = $urlArray['host'];
    $asciiHost = \idn_to_ascii($originalHost, 0, \INTL_IDNA_VARIANT_UTS46);

    if ($asciiHost === false) {
        return $url;
    }

    return \str_replace($originalHost, $asciiHost, $url);
}

function extract_domain(string $url): ?string
{
    $pieces = \parse_url($url);
    $domain = $pieces['host'] ?? '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z.]{2,10})$/i', $domain, $matches)) {
        $matches['domain'] = \preg_replace('/^www./', '', $matches['domain']);
        return $matches['domain'];
    }
    return null;
}

function get_blocked_keywords(): array
{
    return [
        'AT' => [],
        'BE' => [],
        'CH' => ['haus verkaufen'],
        'DE' => [],
        'ES' => [],
        'FR' => [],
        'IT' => [],
        'UK' => [],
        'US' => [],
    ];
}

function get_location_and_language_for_market(string $market): array {
    return [
        'AT' => ['location' => 'Austria', 'language' => 'German'],
        'BE' => ['location' => 'Belgium', 'language' => 'French'],
        'CH' => ['location' => 'Switzerland', 'language' => 'German'],
        'DE' => ['location' => 'Germany', 'language' => 'German'],
        'FR' => ['location' => 'France', 'language' => 'French'],
        'IT' => ['location' => 'Italy', 'language' => 'Italian'],
        'ES' => ['location' => 'Spain', 'language' => 'Spanish'],
        'UK' => ['location' => 'United Kingdom', 'language' => 'English']
    ][$market];
}