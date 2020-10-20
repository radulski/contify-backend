<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\BankAccountDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Models\BankAccountModel;
use App\Traits\UUID;
use App\Exceptions\ApiException;

final class BankAccountController
{
    public function insertBankAccounts(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            if (empty(trim($data['bank_code']))) {
                throw new ApiException("bank_code is required");
            }

            if (empty(trim($data['bank_name']))) {
                throw new ApiException("bank_name is required");
            }

            if (empty(trim($data['agency']))) {
                throw new ApiException("agency is required");
            }

            if (empty(trim($data['account']))) {
                throw new ApiException("account is required");
            }

            $bankAccountDao = new BankAccountDAO();
            $bankAccount = new BankAccountModel();
            
            $tenantId = $company['id'];

            $v4uuid = UUID::v4();

            $bankAccount->setBankCode($data['bank_code'])
                        ->setBankName($data['bank_name'])
                        ->setAgency($data['agency'])
                        ->setAccount($data['account'])
                        ->setTenantId($tenantId)
                        ->setUid($v4uuid)
                        ->setEnable(1)
                        ->setCreatedAt(date('Y-m-d H:i:s'))
                        ->setUpdatedAt(date('Y-m-d H:i:s'));

            $bankAccountDao->insertBankAccount($bankAccount);
            
            return $response->withJson([
                'id' => $bankAccount->getUid(),
                'bank_code' => $bankAccount->getBankCode(),
                'bank_name' => $bankAccount->getBankName(),
                'agency' => $bankAccount->getAgency(),
                'account' => $bankAccount->getAccount(),
                'created_at' => $bankAccount->getCreatedAt(),
                'updated_at' => $bankAccount->getUpdatedAt()
            ], 201);     

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

    public function getBankAccounts(Request $request, Response $response, array $args): Response
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
            
            $bankAccountDao = new BankAccountDAO();
            $bankAccounts = $bankAccountDao->getAllBankAccounts($tenantId);
            $array = array();
            
            foreach ($bankAccounts as $line):
                $array[] = array(
                        "id"         => $line['uid'],
                        "bank_code"  => $line['bankCode'],
                        "bank_name"  => $line['bankName'],
                        "agency"     => $line['agency'],
                        "account"    => $line['account'],
                        'created_at' => $line['createdAt'],
                        'updated_at' => $line['updatedAt']
                 );  
            endforeach;
            
            $response = $response->withJson($array, 200);      
            return $response;

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

    public function getBankAccountsId(Request $request, Response $response, array $args): Response
    {        
        $company_id = $args['company_id'];
        $uid = $args['id'];

        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($company_id);
        
        if ($company) {
            $bankAccountDao = new BankAccountDAO();
            $bankAccounts = $bankAccountDao->getBankAccountsId($uid);

            if ($bankAccounts) {
                $response = $response->withJson([
                    "id"              => $bankAccounts['uid'],
                    "bank_code"       => $bankAccounts['bankCode'],
                    "bank_name"       => $bankAccounts['bankName'],
                    "agency"          => $bankAccounts['agency'],
                    "account"         => $bankAccounts['account'],
                    "document_number" => $bankAccounts['documentNumber']
                ], 200);  
            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Conta bancária não encontrada"
                    )
                ], 422);
            }
        } else {
            $response = $response->withJson([
                'errors' => array(
                    "message" => "Empresa não encontrada"
                )
            ], 422);
        }
  
        return $response;
    }

    public function updateBankAccounts(Request $request, Response $response, array $args): Response
    {     
        $uid = $args['id'];
        $data = $request->getParsedBody();
        $bankAccountDAO = new BankAccountDAO();
        $bankAccount = new BankAccountModel();

        $bankAccount->setBankCode($data['bank_code'])
                ->setBankName($data['bank_name'])
                ->setAgency($data['agency'])
                ->setAccount($data['account'])
                ->setDocumentNumber($data['document_number']);

        $bankAccountDAO->updateBankAccount($bankAccount);
        
        $response = $response->withJson([
            'id' => $bankAccount->getUid(),
            'bank_code' => $bankAccount->getBankCode(),
            'bank_name' => $bankAccount->getBankName(),
            'agency' => $bankAccount->getAgency(),
            'account' => $bankAccount->getAccount(),
            'documentNumber' => $bankAccount->getDocumentNumber()
        ], 200);
        
        return $response;
    }

    public function deleteBankAccounts(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $bankAccountDAO = new BankAccountDAO();
            $bankAccount = $bankAccountDAO->getBankAccountsId($args['id']);

            if ($bankAccount) {
                
                $bankAccountDAO->deleteBankAccount($args['id']);
                
                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Dados bancários não encontrado"
                    )
                ], 422);
            }
            
        } else {
            $response = $response->withJson([
                'errors' => array(
                    "message" => "Empresa não encontrada"
                )
            ], 422);
        }
 
        return $response;
    }


}