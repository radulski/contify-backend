<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\TaxGuideDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Models\TaxGuideModel;
use App\Exceptions\ApiException;

final class TaxGuideController
{    
    public function getTaxGuide(Request $request, Response $response, array $args): Response
    {        
        try {
            $company_id = $args['company_id'];
            
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            foreach ($company as $line):
                $tenantId = $line['id'];
            endforeach;
            
            $taxGuideDao = new TaxGuideDAO();
            $taxGuide = $taxGuideDao->getTaxGuide($tenantId);
            
            return $response->withJson([
                "year"  => $taxGuide['year'],
                "month" => $taxGuide['month'],
                "situation" => $taxGuide['situation'],
                "file" => $taxGuide['file']
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