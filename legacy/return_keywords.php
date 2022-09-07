<?php /** @noinspection PhpUndefinedVariableInspection */

require_once __DIR__ . '/maxRequest.php';
$dataforseo_client = require_once __DIR__ . '/../api/client.php';
require_once __DIR__ . '/functions.php';

$user_searchbox_input = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING);
$market = strtoupper(filter_input(INPUT_GET, 'market', FILTER_SANITIZE_STRING));
$disable_icons = strtoupper(filter_input(INPUT_GET, 'disable_icons', FILTER_SANITIZE_STRING));

$pdo = open_database_connection();


switch (get_search_type_for_query($user_searchbox_input)) {
    case "DOMAIN_SEARCH":
        $keyword_list = remove_duplicates_from_keyword_array(
            domain_search(
                $dataforseo_client,
                $user_searchbox_input,
                $market,
                $pdo)
        );
        break;

    case "KEYWORD_LIST":
        $keyword_list = remove_duplicates_from_keyword_array(
            keyword_list_search(
                $dataforseo_client,
                $user_searchbox_input,
                $market,
                $pdo
            )
        );
        break;

    case "SINGLE_KEYWORD":
        $keyword_list = remove_duplicates_from_keyword_array(
            keyword_search_but_check_cache_first(
                $dataforseo_client,
                $pdo,
                $user_searchbox_input,
                $market
            )
        );
        break;
}

/* Add markup */
$keywords_list_with_markup = [];
foreach ($keyword_list as $keyword_item) {
    $keyword_item['raw_keyword'] = $keyword_item['keyword'];

    if ($disable_icons == '1') {
        $keywords_list_with_markup[] = $keyword_item;
    } else {
        $keywords_list_with_markup[] = add_markup_to_keyword_and_return($keyword_item, $user_searchbox_input, $market);
    }
}

/* Add prices */
$allBlockedKeywords = receive_blocked_keywords_for_all_markets($pdo);
$keywords_list_with_markup_and_prices = $result2Frontend($keywords_list_with_markup, $market, $allBlockedKeywords);

/* Add keyword-not-available-rows */
if (get_search_type_for_query($user_searchbox_input) != "KEYWORD_LIST"){
    $keywords_list_with_markup_and_prices = add_fake_sold_rows($keywords_list_with_markup_and_prices, $user_searchbox_input, $market);
}

/* Expose result to frontend */
echo json_encode(array_values($keywords_list_with_markup_and_prices));

/* Send HTTP response so client sees result but continue execution */
send_http_response_to_client();

/* Write to cache */
if (get_search_type_for_query($user_searchbox_input) == "SINGLE_KEYWORD") {
    write_keyword_list_for_keyword_to_db($keyword_list, $market, $pdo);
} else if (get_search_type_for_query($user_searchbox_input) == "DOMAIN_SEARCH") {
    write_keyword_list_for_domain_to_db($user_searchbox_input, $keyword_list, $market, $pdo);
}


function domain_search($dataforseo_client, $user_searchbox_input, $market, $pdo) {
    $user_searchbox_input = ensure_correct_domain_format($user_searchbox_input);

    $keyword_list = array_merge(
        get_keywords_for_domain_by_search_engine_ranking($dataforseo_client, ensure_correct_domain_format($user_searchbox_input), $market),
        get_keywords_for_domain_by_website_content($dataforseo_client, ensure_correct_domain_with_optional_subdomain_format_for_request($user_searchbox_input), $market)
    );

    log_domain_search($user_searchbox_input, $market, $pdo);

    return $keyword_list;
}


function keyword_list_search($dataforseo_client, $user_searchbox_input, $market, $pdo) {
    $keyword_list = get_data_for_keyword_or_keywords($dataforseo_client, preg_split('/[,;]+/', $user_searchbox_input), $market);

    foreach ($keyword_list as $keyword_item) {
        log_keyword_search($keyword_item['keyword'], $market, $pdo);
    }
    return $keyword_list;
}

function keyword_search_but_check_cache_first($dataforseo_client, $pdo, $user_searchbox_input, $market) {
    $user_search_term_db_id = create_search_term_if_not_exists($pdo, $user_searchbox_input, $market);
    if (is_search_term_connections_large_set_cached($pdo, $user_search_term_db_id)) {
        $original_keyword_item = fetch_connected_search_term_metrics_from_cache($pdo, $user_search_term_db_id);
        $connected_keywords_list = fetch_search_term_metrics_from_cache($pdo, $user_search_term_db_id);

        return array_merge($original_keyword_item, $connected_keywords_list);
    }

    return keyword_search($dataforseo_client, $user_searchbox_input, $market, $pdo);
}


function keyword_search($dataforseo_client, $user_searchbox_input, $market, $pdo) {
    $keyword_list = array_merge(
        get_data_for_keyword_or_keywords($dataforseo_client, [$user_searchbox_input], $market),
        get_keywords_for_keyword($dataforseo_client, $user_searchbox_input, $market)
    );

    log_keyword_search($user_searchbox_input, $market, $pdo);

    return $keyword_list;
}


/* Requires PHP-FPM */
function send_http_response_to_client() {
    session_write_close();
    ignore_user_abort(true);
    fastcgi_finish_request();
}


function write_keyword_list_for_keyword_to_db($keyword_list, $market, $pdo) {
    $originSearchTermId = create_search_term_if_not_exists($pdo, $keyword_list[0]['keyword'], $market);

    foreach ($keyword_list as $keyword_item) {
        log_keyword_search($keyword_item['keyword'], $market, $pdo);

        $connectedSearchTermId = create_search_term_if_not_exists($pdo, $keyword_item['keyword'], $market);
        create_search_term_connection($pdo, $originSearchTermId, $connectedSearchTermId);

        add_search_term_metric(
            $pdo, $connectedSearchTermId, $keyword_item['search_volume'], $keyword_item['cpc'], $keyword_item['competition']
        );
    }

    update_search_term_last_connection_check_date($pdo, $originSearchTermId);
}


function write_keyword_list_for_domain_to_db($user_searchbox_input, $keyword_list, $market, $pdo) {
    foreach ($keyword_list as $keyword_item) {
        log_keyword_search($keyword_item['keyword'], $market, $pdo);

        $searchTermId = create_search_term_if_not_exists($pdo, $keyword_item['keyword'], $market);

        add_search_term_metric(
            $pdo, $searchTermId, $keyword_item['search_volume'], $keyword_item['cpc'], $keyword_item['competition']
        );
    }
}


function get_search_type_for_query($user_query) {
    if (mb_strpos($user_query, '.') !== false) {
        return "DOMAIN_SEARCH";
    }

    if (mb_strpos($user_query, ',') !== false || mb_strpos($user_query, ';') !== false) {
        return "KEYWORD_LIST";
    }

    return "SINGLE_KEYWORD";
}


function get_keywords_for_domain_by_website_content($client, $domain_name, $market) {
    $request_parameters[] = [
        'target' => $domain_name,
        'location_name' => get_location_and_language_for_market($market)['location'],
        'language_name' => get_location_and_language_for_market($market)['language'],
    ];

    $result = $client->post('/v3/keywords_data/google/keywords_for_site/live', $request_parameters);

    $keywords_to_return = [];
    if (is_array($result['tasks'][0]['result']) || is_object($result['tasks'][0]['result'])) {
        foreach ($result['tasks'][0]['result'] as $keyword_item) {
            if (is_brand_keyword($keyword_item['keyword'], $domain_name)) {
                continue;
            }

            $keyword_to_add['keyword'] = $keyword_item['keyword'];
            $keyword_to_add['search_volume'] = (int) $keyword_item['search_volume'] ?? 0;
            $keyword_to_add['cpc'] = (float) $keyword_item['cpc'] ?? 0;
            $keyword_to_add['competition'] = (float) $keyword_item['competition'] ?? 0;
            $keyword_to_add['market'] = $market;

            $keywords_to_return[] = $keyword_to_add;
        }
    }

    return $keywords_to_return;
}


function get_keywords_for_domain_by_search_engine_ranking($client, $domain_name, $market) {
    $request_parameters[] = [
        'target' => $domain_name,
        'location_name' => get_location_and_language_for_market($market)['location'],
        'language_name' => get_location_and_language_for_market($market)['language'],
        'limit' => 300,
        'order_by' => ["keyword_data.keyword_info.cpc,desc", "keyword_data.keyword_info.search_volume,desc"],
        'filters' => [
            ['ranked_serp_element.serp_item.rank_group', '<', 200],
            'and',
            ['keyword_data.keyword_info.search_volume', '<', 35000],
        ]
    ];

    $raw_request_result = $client->post('/v3/dataforseo_labs/ranked_keywords/live', $request_parameters);
    $mapped_and_filtered_keywords = [];

    if (is_array($raw_request_result['tasks'][0]['result'][0]['items']) || is_object($raw_request_result['tasks'][0]['result'][0]['items'])) {
        foreach ($raw_request_result['tasks'][0]['result'][0]['items'] as $keyword_item) {
            if (is_brand_keyword($keyword_item['keyword_data']['keyword'], $domain_name)) {
                continue;
            }

            $keyword_to_add['keyword'] = $keyword_item['keyword_data']['keyword'];
            $keyword_to_add['search_volume'] = $keyword_item['keyword_data']['keyword_info']['search_volume'] ?? 0;
            $keyword_to_add['cpc'] = $keyword_item['keyword_data']['keyword_info']['cpc'] ?? 0;
            $keyword_to_add['competition'] = $keyword_item['keyword_data']['keyword_info']['competition'] ?? 0;
            $keyword_to_add['market'] = $market;

            $mapped_and_filtered_keywords[] = $keyword_to_add;
        }
    }

    return $mapped_and_filtered_keywords;
}


function get_keywords_for_keyword($client, $starting_keyword_text, $market) {
    $request_parameters[] = [
        'keywords' => [$starting_keyword_text],
        'location_name' => get_location_and_language_for_market($market)['location'],
        'language_name' => get_location_and_language_for_market($market)['language'],
    ];

    $raw_request_result = $client->post('/v3/keywords_data/google/keywords_for_keywords/live', $request_parameters);

    $mapped_and_filtered_keywords = [];

    foreach ($raw_request_result['tasks'][0]['result'] as $keyword_item) {
        $keyword_to_add['keyword'] = $keyword_item['keyword'];
        $keyword_to_add['search_volume'] = $keyword_item['search_volume'] ?? 0;
        $keyword_to_add['cpc'] = $keyword_item['cpc'] ?? 0;
        $keyword_to_add['competition'] = $keyword_item['competition'] ?? 0;
        $keyword_to_add['market'] = $market;

        $mapped_and_filtered_keywords[] = $keyword_to_add;
    }

    return $mapped_and_filtered_keywords;
}


function get_data_for_keyword_or_keywords($client, $input_keywords_array, $market) {
    $input_keywords_array = filter_special_characters($input_keywords_array);

    $request_parameters[] = [
        'keywords' => $input_keywords_array,
        'location_name' => get_location_and_language_for_market($market)['location'],
        'language_name' => get_location_and_language_for_market($market)['language'],
    ];

    $raw_request_result = $client->post('/v3/keywords_data/google_ads/search_volume/live', $request_parameters);

    $mapped_and_filtered_keywords = [];

    foreach ($raw_request_result['tasks'][0]['result'] as $keyword_item) {
        $keyword_to_add['keyword'] = $keyword_item['keyword'];
        $keyword_to_add['search_volume'] = $keyword_item['search_volume'] ?? 0;
        $keyword_to_add['cpc'] = $keyword_item['high_top_of_page_bid'] ?? 0;
        $keyword_to_add['competition'] = $keyword_item['competition_index'] ?? 0;
        $keyword_to_add['market'] = $market;

        $mapped_and_filtered_keywords[] = $keyword_to_add;
    }

    return $mapped_and_filtered_keywords;
}


function is_brand_keyword($keyword_text, $domain_of_prospect) {
    if (strpos($keyword_text, explode(".", $domain_of_prospect)[0]) !== false) {
        return true;
    }

    return false;
}


function ensure_correct_domain_with_optional_subdomain_format_for_request($input_domain) {
    if (mb_strpos($input_domain, 'https://') === false) {
        $input_domain = 'https://' . $input_domain;
    }
    return idn_host_to_ascii($input_domain);
}


function ensure_correct_domain_format($input_domain) {
    $input_domain = str_replace('http://', 'https://', $input_domain);

    if (mb_strpos($input_domain, 'https://') === false) {
        $input_domain = 'https://' . $input_domain;
    }

    return idn_host_to_ascii(extract_domain($input_domain));
}


function add_markup_to_keyword_and_return($keyword_to_add, $user_searchbox_input, $market) {
    $keyword_plain_text = $keyword_to_add['keyword'];

    $keyword_to_add['keyword'] = '<span style="display: flex;">' . $keyword_to_add['keyword'];

    $progress_bar_sv_fill = ((int) $keyword_to_add['search_volume'] / 10) + 15;
    if ($progress_bar_sv_fill > 100) {
        $progress_bar_sv_fill = 100;
    }

    $visitor_estimated_low = (int) log($keyword_to_add['search_volume'] + 1) * 10 * 0.2 + 2;
    $visitor_estimated_high = (int) log($keyword_to_add['search_volume'] + 2) * 10 * 1.2 + 12;

    if ($keyword_to_add['search_volume'] < 300) {
        $text_to_show_for_sv = 'This keyword probably has a few hundred monthly searches but it is difficult to get a reliable estimate. <br /><br />' .
            'You can expect roughly ' . $visitor_estimated_low . " - " . $visitor_estimated_high . ' website visitors from that keyword per month but results may vary.';
    } else {
        $text_to_show_for_sv = 'This keyword has roughly ' . $keyword_to_add['search_volume'] . ' monthly searches. <br /><br />' .
            'You can expect roughly ' . $visitor_estimated_low . " - " . $visitor_estimated_high . ' website visitors from that keyword per month but results may vary.';

    }

    $keyword_to_add['keyword'] .= '<div style="display: flex; margin-left: 20px; margin-top: 4px;"><div class="progress" style="width: 50px; height: 12px;"
           onMouseover="ddrivetip(\'' . $text_to_show_for_sv . '\',\'#FFF\', 300)"; onMouseout="hideddrivetip()">
          <div class="progress-bar" role="progressbar" style="width: ' . $progress_bar_sv_fill . '%; background-color: #007bff;"
           aria-valuenow="' . $progress_bar_sv_fill . '" aria-valuemin="0" aria-valuemax="100"></div>
        </div>';

    $progress_bar_cpc_fill = ((float) $keyword_to_add['cpc'] * 10) + 15;
    if ($progress_bar_cpc_fill > 100) {
        $progress_bar_cpc_fill = 100;
    }

    $text_to_show_for_cpc = 'Using paid search engine ads, it would roughly cost ' . round(($keyword_to_add['cpc'] + 2.98), 2) . '€ to acquire a single website visitor from that keyword. <br /><br />' .
        'With autocomplete marketing, acquisition costs are likely lower and your ROI higher. ';

    $keyword_to_add['keyword'] .= '<div class="progress" style="width: 50px; height: 12px;"
           onMouseover="ddrivetip(\'' . $text_to_show_for_cpc . '\',\'#FFF\', 300)"; onMouseout="hideddrivetip()">
          <div class="progress-bar" role="progressbar" style="width: ' . $progress_bar_cpc_fill . '%; background-color: #dc3545;"
           aria-valuenow="' . $progress_bar_cpc_fill . '" aria-valuemin="0" aria-valuemax="100"></div>
        </div>';

    $keyword_to_add['keyword'] .= '</span>';

    $keyword_to_add['keyword'] .= '<span style="font-size: 20px; margin-left: 10px; margin-top: -10px; width: 90px;">';


    /* Suggest preview tooltip */
    if (get_search_type_for_query($user_searchbox_input) == "DOMAIN_SEARCH") {
        $secret = time() * 13 * 17; /* product of prime number factors to authenticate request */
        $user_brand_name = explode(".", ensure_correct_domain_format($user_searchbox_input))[0]; /* domain.tld */

        $keyword_to_add['keyword'] .= "<a href=\"#\" onMouseover=\"ddrivetip('<iframe src=\'https://www.autosuggest.net/keyword-finder/return_suggest_preview.php?keyword=$keyword_plain_text&brand=$user_brand_name&market=$market&secret=$secret\' width=\'508px\' height=\'356px\' frameBorder=\'0px\' />', '#FFF', 518)\"; onMouseout='hideddrivetip()'\">📺</a>";
    }

    if ((int) $keyword_to_add['search_volume'] > 100) {
        $keyword_to_add['keyword'] .= '<a href="#" onMouseover="ddrivetip(\'This keyword appeared in many searches in the last 24 hours and others seem interested as well.\',\'#FFF\', 300)"; onMouseout="hideddrivetip()">🌶</a>';
    }

    if ((int) $keyword_to_add['search_volume'] <= 100 || (float) $keyword_to_add['cpc'] > 3) {
        $keyword_to_add['keyword'] .= '<a href="#" onMouseover="ddrivetip(\'This keyword will likely generate very targeted traffic and high converting visitors.\',\'#FFF\', 300)"; onMouseout="hideddrivetip()">🎯</a>';
    }

    if ((float) $keyword_to_add['competition'] * (int) $keyword_to_add['search_volume'] * (float) $keyword_to_add['cpc'] > 1000) {
        $keyword_to_add['keyword'] .= '<a href="#" onMouseover="ddrivetip(\'This keyword is currently included in a quote and might become unavailable at any time.\',\'#FFF\', 300)"; onMouseout="hideddrivetip()">🔥</a>';
    }

    if ((int) $keyword_to_add['search_volume'] > 1000) {
        $keyword_to_add['keyword'] .= '<a href="#" onMouseover="ddrivetip(\'This keyword is great for branding and would likely increase brand recall.\',\'#FFF\', 300)"; onMouseout="hideddrivetip()">🏆</a>';
    }

    $keyword_to_add['keyword'] .= '</span></div>';

    return $keyword_to_add;
}


function add_fake_sold_rows($keywords_list_with_prices, $original_user_input, $market) {
    if (get_search_type_for_query($original_user_input) === 'KEYWORD_LIST') {
        return $keywords_list_with_prices;
    }

    $keyword_list_with_prices_and_fake_sold_keywords = [];
    $skipNumberBasis = crc32($market . $original_user_input) * 781932311;
    $skipNumber = 0;
    $numberOfResultForSkipping = 0;

    foreach ($keywords_list_with_prices as $keyword_item) {
        $numberOfResultForSkipping++;
        $keyword_list_with_prices_and_fake_sold_keywords[] = $keyword_item;

        if ($skipNumber >= mb_strlen($skipNumberBasis) - 1) {
            $skipNumber = 0;
        }

        $numberToSkip = substr($skipNumberBasis, $skipNumber, 1) + 3;


        if ($numberOfResultForSkipping === $numberToSkip) {
            $item_variance = 0;
            $fake_keyword_text = '';

            $numberOfResultForSkipping = 0;
            $skipNumber++;

            $fake_keyword_text_length = 13 + (strlen($keyword_item['keyword']) % 9);
            $whitespace_position = $fake_keyword_text_length - 3 - (strlen($keyword_item['keyword']) % 5);

            for ($i = 0; $i < $fake_keyword_text_length; $i++){
                if ($i === $whitespace_position) {
                    $fake_keyword_text .= ' ';
                    continue;
                }
                $fake_keyword_text .= ($skipNumberBasis . "514545254874516841764651341567848453")[$i];

                if ($item_variance > 10) {
                    $item_variance = 3;
                } else {
                    $item_variance++;
                }
            }

            $keyword_list_with_prices_and_fake_sold_keywords[] = ['keyword' => '<span style="filter: blur(5px);user-select: none;pointer-events: none;font-size: 14px">' . $fake_keyword_text . '</span>', 'price' => -2];
        }
    }

    return $keyword_list_with_prices_and_fake_sold_keywords;
}


function add_search_term_metric(
    PDO $pdo,
    int $searchTermId,
    int $searchVolume,
    float $cpc,
    float $competition
): void {
    try {
        $insert = $pdo->prepare('
            INSERT INTO `search_term_metrics` (`search_term_id`, `creation_date`, `search_volume`, `cpc`, `competition`)
            VALUES (:search_term_id, CURDATE(), :search_volume, :cpc, :competition)
        ');
        $insert->bindParam(':search_term_id', $searchTermId);
        $insert->bindParam(':search_volume', $searchVolume);
        $insert->bindParam(':cpc', $cpc);
        $insert->bindParam(':competition', $competition);
        $insert->execute();
    } catch (PDOException $e) {
        /* We handle this exception as otherwise it will propagate up and stop the script if one search_term_metrics
        would create a duplicate, which is quite likely e.g. if a user does several, similar searches on the same day */
        echo 'PDOException: likely because of Integrity constraint violation for unique date. This can be ignored.';
    }
}


function is_search_term_connections_large_set_cached(PDO $pdo, int $searchTermId): bool
{
    /* From 2022-01-06 larger cache writes (more results) were done, earlier entries do not count as cached */
    $result = $pdo->prepare('
        SELECT 1 FROM `search_terms` WHERE `id` = :id AND
        `last_connections_check_date` > DATE_SUB(NOW(), INTERVAL 4 MONTH) AND
        `last_connections_check_date` < DATE_SUB(NOW(), INTERVAL 2 MINUTE) AND
        `last_connections_check_date` >= \'2022-01-06\'
    ');
    $result->bindParam(':id', $searchTermId);
    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row !== false;
}


function remove_duplicates_from_keyword_array($input_array): array {
    return array_reverse(array_values(array_column(
        array_reverse($input_array),
        null,
        'keyword'
    )));
}
