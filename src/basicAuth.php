<?php

namespace src;

use Tuupola\Middleware\HttpBasicAuthentication;
use App\DAO\MySQL\ContifyDev\TokenDAO;

function basicAuth(): HttpBasicAuthentication
{ 
    $auth = null;

    if (isset($_SERVER['PHP_AUTH_PW'])) {
        $token = $_SERVER['PHP_AUTH_PW'];
        $tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);
        
        if ($tokenType == "TEST_") {
            $token = substr($_SERVER['PHP_AUTH_PW'], 5);
        }

        $tokenDao = new TokenDAO();
        $responseToken = $tokenDao->getTokenId($token);

        if ($responseToken) {
            $auth = $_SERVER['PHP_AUTH_PW'];
        }
    }

    return new HttpBasicAuthentication([
        "secure" => false,
        "users" => [
            "" => $auth
        ],
        "error" => function ($response, $arguments) {
            $data = [];
            $data["errors"] = $arguments["message"];
            return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        }
    ]);
}