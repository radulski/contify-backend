<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\TransferDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Models\TransferModel;
use App\Models\FinancialMovementModel;
use App\DAO\MySQL\ContifyDev\FinancialMovementDAO;
use App\DAO\MySQL\ContifyDev\BankAccountDAO;
use App\Traits\UUID;
use App\Exceptions\ApiException;

final class TransferController
{    
    public function getTransfers(Request $request, Response $response, array $args): Response
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
            
            $transfersDao = new TransferDAO();
            $transfers = $transfersDao->getAllTransfers($tenantId);

            foreach ($transfers as $line):
                $array[] = array(
                    "id"  => $line['uid'],
                    "value" => $line['value'], 
                    "origin_bank_account_id" =>  $line['originBankAccountId'],
                    "destination_bank_account_id" =>  $line['destinationBankAccountId']                        
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

    public function getTransfersId(Request $request, Response $response, array $args): Response
    {                  
        try {
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $transfersDao = new TransferDAO();
            $transfers = $transfersDao->getTransfersId($uid);

            if (!$transfers) {
                throw new ApiException("Transfer not found");
            }

            return $response->withJson([
                "id"  => $transfers['uid'],
                "value" => $transfers['value'],
                "origin_bank_account_id" => $transfers['originBankAccountId'],
                "destination_bank_account_id" => $transfers['destinationBankAccountId']
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

    public function insertTransfers(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            if (empty(trim($data['value']))) {
                throw new ApiException("value is required");
            }

            if (empty(trim($data['date']))) {
                throw new ApiException("date is required");
            }

            $bankAccountDao = new BankAccountDAO();
            $bankAccountOrigin = $bankAccountDao->getBankAccountsId($data['origin_bank_account_id']);
            $bankAccountDestination = $bankAccountDao->getBankAccountsId($data['destination_bank_account_id']);

            if (!$bankAccountOrigin) {
                throw new ApiException("Origin Bank Account not found");
            } 

            if (!$bankAccountDestination) {
                throw new ApiException("Destination Bank Account not found");
            } 

            $tenantId = $company['id'];
            $transferDao = new TransferDAO();
            $transfer = new TransferModel();
            
            $v4uuid = UUID::v4();

            $transfer->setUid($v4uuid)
                    ->setTenantId($tenantId)
                    ->setEnable(1)
                    ->setName($data['name'])
                    ->setOriginBankAccountId($bankAccountOrigin['id'])
                    ->setDestinationBankAccountId($bankAccountDestination['id'])
                    ->setCreatedAt(date('Y-m-d H:i:s'));

            $transfer_id = $transferDao->insertTransfer($transfer);

            //Insere nos lançamentos
            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = new FinancialMovementModel();
            $v4uuidl = UUID::v4();
                        
            $financialMovement->setValue($data['value'])
                    ->setEnable(1)
                    ->setTenantId($tenantId)
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUpdatedAt(date('Y-m-d H:i:s'))
                    ->setContactId(null)
                    ->setDate($data['date'])
                    ->setTransferId($transfer_id)
                    ->setBankAccountId($bankAccountOrigin['id'])
                    ->setNotes(null)
                    ->setUid(null)
                    ->setMovementType('D');
            
            $financialMovementDao->insertFinancialMovement($financialMovement);

            $financialMovement->setValue($data['value'])
                    ->setEnable(1)
                    ->setTenantId($tenantId)
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUpdatedAt(date('Y-m-d H:i:s'))
                    ->setContactId(null)
                    ->setDate($data['date'])
                    ->setTransferId($transfer_id)
                    ->setBankAccountId($bankAccountDestination['id'])
                    ->setNotes($data['notes'])
                    ->setUid(null)
                    ->setMovementType('R');
    
            $financialMovementDao->insertFinancialMovement($financialMovement);

            return $response->withJson([
                'id' => $v4uuid,
                'created_at' => $transfer->getCreatedAt()
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

    public function deleteTransfers(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $transferDao = new TransferDAO();
            $trasnfers = $transferDao->getTransfersId($args['id']);



            if ($trasnfers) {

                echo 'id ' . $trasnfers['id'];
                
                $transferDao->deleteTransfer($args['id']);
                
                //Excluir todas as transferencias dos lançamentos vinculados
                $financialMovementDao = new FinancialMovementDAO();
                $deleteTransfers = $financialMovementDao->deleteFinancialMovementByIdTransfer($trasnfers['id']);

                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Transfer not found"
                    )
                ], 422);
            }
            
        } else {
            $response = $response->withJson([
                'errors' => array(
                    "message" => "Company not found"
                )
            ], 422);
        }
 
        return $response;
    }
}