<?php
namespace App\Services;

class CompanyServiceBean implements CompanyService {
    
    public function insertCompanies(): Response {
        return $response->withJson([
            "id1" => 1
        ]);
    }
}