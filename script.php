<?php 
/*
$url = 'http://localhost:8888/contify/v1/companies/insert_integration_companies';
 
$username = '';

$password = 'TEST_ZGRiZDM1OTZlZjZhMWI3ZTUzZDQyMzQ2MjUzNDU2ZDc2YmM5ODliZjM3N2I1NDI1ODM1NWFjMzZkMTQ5MzI0NGZkOTFmZDFlODBiNWY2ZDdmYTQzNTZjZjI1NDIzMDdlM2Q1MzFmZWVjZmI1ZTE2MmNkMzcyZmQ0NGVjZjQzNDE=';
 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
 
if (curl_errno($ch)) {
    //throw new Exception(curl_error($ch));
    echo "erro";
} else {
    echo "certo";
}

echo $response;
*/


$url = 'http://localhost:8888/contify/v1/companies/insert_integration_companies'; 

$client_id  = "";
$client_pass = "TEST_ZGRiZDM1OTZlZjZhMWI3ZTUzZDQyMzQ2MjUzNDU2ZDc2YmM5ODliZjM3N2I1NDI1ODM1NWFjMzZkMTQ5MzI0NGZkOTFmZDFlODBiNWY2ZDdmYTQzNTZjZjI1NDIzMDdlM2Q1MzFmZWVjZmI1ZTE2MmNkMzcyZmQ0NGVjZjQzNDE="; 

$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => array ('Content-type: application/json', 'Authorization: Basic '.base64_encode("$client_id:$client_pass")),
        'content' => "some_content"
    )
);

$context = stream_context_create($opts);
$json = file_get_contents($url, false, $context);

$result = json_decode($json, true);
if (json_last_error() != JSON_ERROR_NONE) {
    return null;
}

print_r($result);