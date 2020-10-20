<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Traits\UUID;
use App\Exceptions\ApiException;
use App\Models\UserTokenModel;
use App\DAO\MySQL\ContifyDev\UserTokenDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;

final class LoginController {    
    
    public function login(Request $request, Response $response, array $args): Response {
        //global $renderer;
        //$response = $renderer->render($response, 'login.php', ['customers' => "123"]);
        //return $response;

        return $response->withRedirect('https://www.google.com', 302);

        //retornar json com os dados do usuário

        //return $response->withRedirect('http://localhost:4200', 302);
    }

    public function revokeToken(Request $request, Response $response, array $args): Response {

        $userTokenDao = new UserTokenDAO();
        $userTokenDao->deleteToken();

        $response = $response->withJson([
            'deleted' => "true"
        ], 200);

        return $response;
    }

    public function generateToken(Request $request, Response $response, array $args): Response {
       try {
            $data = $request->getParsedBody();

            $company_id = $args['company_id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            // $token = $data['token'];

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $temporaryToken = "123456";

            $userToken = new UserTokenModel();
            $userToken->setToken($temporaryToken);

            $userTokenDao = new UserTokenDAO();
            $userTokenDao->generateToken($userToken);
            

            return $response->withJson([
                "token"  => $userToken->getToken(),
                "expirationDate" => "2020/08/05"
            ], 200);  
        
        } catch(ApiException $ex) {
            return $response->withJson([
                'errors' => array(
                    "message" => $ex->getMessage()
                )
            ], 422);   

        } catch(\Exception | \Throwable $ex) {
            
            return $response->withJson([
                'errors' => array(
                    "message" => $ex->getMessage()
                )
            ], 500);
        }
    }
}