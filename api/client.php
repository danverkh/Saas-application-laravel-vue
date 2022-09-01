<?php

use App\Services\RestClient;

require_once __DIR__ . '/RestClient.php';

$api_url = 'https://api.dataforseo.com/';
$user = 'stefan@autosuggest.io';
$password = '4abbf968ca51f96c';

try {
  return new RestClient($api_url, null, $user, $password);
} catch (RestClientException $e) {
  echo "\n";
  print "HTTP code: {$e->getHttpCode()}\n";
  print "Error code: {$e->getCode()}\n";
  print "Message: {$e->getMessage()}\n";
  print  $e->getTraceAsString();
  echo "\n";
  exit();
}
