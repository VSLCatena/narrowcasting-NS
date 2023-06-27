<?php
include('./env.php');
header('Content-Type: application/json; charset=utf-8');

// Create a stream
    $opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n" .
        "Ocp-Apim-Subscription-Key:" . NS_API_KEY . "\r\n"
    )
);
$context = stream_context_create($opts);
   
if(isset($_GET['page']) && $_GET['page'] == 'disruptions'){
   $jsonurl = "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/disruptions/station/" . NS_STATION_ID;
   $response = file_get_contents($jsonurl, true, $context);
   echo $response;
   
} elseif(isset($_GET['page']) && $_GET['page'] == 'departures'){
   $jsonurl = "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures?maxJourneys=25&lang=nl&uicCode=" . NS_STATION_ID;
   #$jsonurl = "https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures?maxJourneys=25&dateTime=$randomDateFuture&lang=nl&uicCode=" . NS_STATION_ID;
   $response = file_get_contents($jsonurl, false, $context);
   echo $response;

} else {

    return false;

}
