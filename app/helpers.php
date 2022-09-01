<?php

if (!function_exists('isDomainName')) {
    function isDomainName($domain)
    {
        $pattern = '/^(http[s]?\:\/\/)?(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
        return preg_match($pattern, $domain) === 1 || checkdnsrr($domain);
    }
}

if (!function_exists('http_parse_headers')) {
    function http_parse_headers($raw_headers)
    {
        $headers = [];
        $key     = ''; // [+]

        foreach (explode("\n", $raw_headers) as $i => $h) {
            $h = explode(':', $h, 2);
            if (isset($h[1])) {
                if (!isset($headers[$h[0]]))
                    $headers[$h[0]] = trim($h[1]);
                elseif (is_array($headers[$h[0]])) {
                    // $tmp = array_merge($headers[$h[0]], array(trim($h[1]))); // [-]
                    // $headers[$h[0]] = $tmp; // [-]
                    $headers[$h[0]] = array_merge($headers[$h[0]], [trim($h[1])]); // [+]
                } else {
                    // $tmp = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [-]
                    // $headers[$h[0]] = $tmp; // [-]
                    $headers[$h[0]] = array_merge([$headers[$h[0]]], [trim($h[1])]); // [+]
                }

                $key = $h[0]; // [+]
            } else // [+]
            { // [+]
                if (substr($h[0], 0, 1) == "\t") // [+]
                    $headers[$key] .= "\r\n\t" . trim($h[0]); // [+]
                elseif (!$key) // [+]
                    $headers[0] = trim($h[0]); // [+]
            } // [+]
        }

        return $headers;
    }
}
