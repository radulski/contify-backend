<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\FinancialMovementDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\DAO\MySQL\ContifyDev\CustomerDAO;
use App\DAO\MySQL\ContifyDev\BankAccountDAO;
use App\Models\FinancialMovementModel;
use App\Models\CategoryLaunchModel;
use App\DAO\MySQL\ContifyDev\CategoryLaunchDAO;
use App\DAO\MySQL\ContifyDev\CategoryDAO;
use App\Traits\UUID;
use App\Exceptions\ApiException;

final class FinancialMovementController
{ 
    public function getFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        $financialMovementDao = new FinancialMovementDAO();
        $financialMovement = $financialMovementDao->getAllFinancialMovements();
        $array = array();

        foreach ($financialMovement as $line):
            $array[] = array(
                    "id"  => $line['uid'],
                    "customer_id" => $line['contact_id'],
                    "value" => $line['value'],
                    "bank" => $line['bank'],
                    "agency" => $line['agency'],
                    "account" => $line['account'],
                    "document_number" => $line['document_number'],
                    "date" => $line['date'],
                    "notes" => $line['description']
             );  
        endforeach;

        $response = $response->withJson($array, 200); 
        return $response;
    }

    public function getFinancialMovementId(Request $request, Response $response, array $args): Response
    {   
        $uid = $args['id'];
        $financialMovementDao = new FinancialMovementDAO();
        $financialMovement = $financialMovementDao->getFinancialMovementsId($uid);
        $array = array();

        
        foreach ($financialMovement as $line):
            $array = array(
                    "id"  => $line['uid'],
                    "customer_id" => $line['contact_id'],
                    "value" => $line['value'],
                    "bank" => $line['bank'],
                    "agency" => $line['agency'],
                    "account" => $line['account'],
                    "document_number" => $line['document_number'],
                    "date" => $line['date'],
                    "notes" => $line['description']
             );  
        endforeach;

        $response = $response->withJson($array, 200); 
        return $response;
    }

    public function insertFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        try {
            $data = $request->getParsedBody();
            
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            if (empty(trim($data['customer_id']))) {
                throw new ApiException("customer_id is required");
            }

            if (empty(trim($data['bank_account_id']))) {
                throw new ApiException("bank_account_id is required");
            }

            if (empty(trim($data['movement_type']))) {
                throw new ApiException("movement_type is required");
            }

            if (empty(trim($data['date']))) {
                throw new ApiException("date is required");
            }

            $customerDao = new CustomerDAO();
            $customer = $customerDao->getCustomersId($data['customer_id']);
            if (!$customer) {
                throw new ApiException("Customer not found");
            } 

            $bankAccountDao = new BankAccountDAO();
            $bankAccount = $bankAccountDao->getBankAccountsId($data['bank_account_id']);
            if (!$bankAccount) {
                throw new ApiException("Bank Account not found");
            } 

            foreach($data['categories'] as $dados){          
                $categoryId = isset($dados['category_id']) ? $dados['category_id'] : null;
                $categoryValue = isset($dados['value']) ? $dados['value'] : null;

                $categoryDao = new CategoryDAO();
                $category = $categoryDao->getCategoriesId($dados['category_id']);
                if (!$category) {
                    throw new ApiException("Category not found");
                } 

                if (!$categoryId) {
                    throw new ApiException("Category is required");
                }
                if (!$categoryValue) {
                    throw new ApiException("Value is required");
                }             
            }

            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = new FinancialMovementModel();
            
            $tenantId = $company['id'];
            $v4uuid = UUID::v4();

            $value=0;
            $financialMovement->setValue($value)
                    ->setUid($v4uuid)
                    ->setEnable(1)
                    ->setTenantId($tenantId)
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUpdatedAt(date('Y-m-d H:i:s'))
                    ->setContactId($customer['id'])
                    ->setDate($data['date'])
                    ->setBankAccountId($bankAccount['id'])
                    ->setBankAccountUid($data['bank_account_id'])
                    ->setNotes($data['notes'])
                    ->setMovementType($data['movement_type']);

            $launch_id = $financialMovementDao->insertFinancialMovement($financialMovement);
            
            foreach($data['categories'] as $dados){    
                $v4uuidCategory = UUID::v4();
                
                //pegar id da categoria pelo uid
                $category_id = $financialMovementDao->getCategoryId($dados['category_id']);
                
                $category = (new CategoryLaunchModel())->setCategoryId($category_id['id'])
                            ->setUid($v4uuidCategory)                    
                            ->setValue($dados['value'])
                            ->setTenantId($tenantId)
                            ->setLaunchid($launch_id); 
                $categoryDao = (new CategoryLaunchDao())->insertCategoriesLaunch($category);
            }

            return $response->withJson([
                'id' => $financialMovement->getUid(),
                'customer_id' => $data['customer_id'],
                'bank_account_id' => $data['bank_account_id'],
                'movement_type' => $financialMovement->getMovementType(),
                'date' => $financialMovement->getDate(),
                'notes' => $financialMovement->getNotes(),
                'created_at' => $financialMovement->getCreatedAt(),
                'updated_at' => $financialMovement->getUpdatedAt()
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
        
        /*
        $company_id = $args['company_id'];

        $data = $request->getParsedBody();
        $financialMovementDao = new FinancialMovementDAO();
        $financialMovement = new FinancialMovementModel();
        $companyDao = new CompanyDAO();
        $customerDao = new CustomerDAO();
        $bankAccountDao = new BankAccountDAO();

        $company = $companyDao->getCompaniesId($args['company_id']);

        if ($company) {                
            $customer = $customerDao->getCustomersId($data['customer_id']);
            $tenantId = $company['id'];

            if ($customer) {
                $bankAccount = $bankAccountDao->getBankAccountsId($data['bank_account_id']);

                if ($bankAccount) {
                    $v4uuid = UUID::v4();

                    $financialMovement->setValue($data['value'])
                                ->setUid($v4uuid)
                                ->setEnable(1)
                                ->setTenantId($tenantId)
                                ->setCreatedAt(date('Y-m-d H:i:s'))
                                ->setContactId($customer['id'])
                                ->setDate($data['date'])
                                ->setBankAccountId($bankAccount['id'])
                                ->setBankAccountUid($data['bank_account_id'])
                                ->setNotes($data['notes'])
                                ->setMovementType($data['movement_type'])
                                ->setCategoryName($data['category_name']);
                                
                    $financialMovementDao->insertFinancialMovement($financialMovement);
                    
                    $response = $response->withJson([
                        'id' => $financialMovement->getUid(),
                        'customer_id' => $financialMovement->getContactId(),
                        'bank_account_id' => $financialMovement->getBankAccountUid(),
                        'movement_type' => $financialMovement->getMovementType(),
                        'category_name' => $financialMovement->getCategoryName(),
                        'date' => $financialMovement->getDate(),
                        'notes' => $financialMovement->getNotes(),
                        'value' => $financialMovement->getValue()
                    ], 201);
                } else {
                    $response = $response->withJson([
                        'errors' => array(
                            "message" => "bank_account_id not found"
                        )
                    ], 422);
                }
            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "customer_id not found"
                    )
                ], 422);
            }
        } else {
            $response = $response->withJson([
                'errors' => array(
                    "message" => "company_id not found"
                )
            ], 422);
        }

        return $response; 
        */   
    }

    public function updateFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        try {
            $uid = $args['id'];
            $data = $request->getParsedBody();
            
            $financialMovementDAO = new FinancialMovementDAO();
            $financialMovement = new FinancialMovementModel();

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            $financialMovementsDao = new CategoryDAO();
            $financialMovemens = $financialMovementsDao->getCategoriesId($uid);

            if (!$financialMovemens) {
                throw new ApiException("Financial Movements not found");
            }

            if (!$data){
                return $response->withJson([
                    "id"  => $categories['uid'],
                    "name" => $categories['name'],
                    "created_at" => $categories['createdAt'],
                    "updated_at" => $categories['updatedAt']
                ], 200); 
                
                die;
            }

            if (empty(trim($data['name']))) {
                throw new ApiException("Name is required");
            }
            
            $category->setName($data['name'])
                ->setUid($uid)
                ->setUpdatedAt(date('Y-m-d H:i:s'));

            $categoryDAO->updateCategory($category);
            
            //selecionar categorias após atualização
            $categories = $categoriesDao->getCategoriesId($uid);

            return $response->withJson([
                "id"  => $categories['uid'],
                "name" => $categories['name'],
                "created_at" => $categories['createdAt'],
                "updated_at" => $categories['updatedAt']
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
        
        /*
        $uid = $args['id'];
        $data = $request->getParsedBody();
        $financialMovementDAO = new FinancialMovementDAO();
        $financialMovement = new FinancialMovementModel();

        $financialMovement->setName($data['name'])
            ->setUid($uid)
            ->setEmail($data['email'])
            ->setPhone($data['phone'])
            ->setPersonType($data['person_type'])
            ->setDocument($data['document'])
            ->setStateRegistrationNumber($data['state_registration_number'])
            ->setDateOfBirth($data['date_of_birth'])
            ->setNotes($data['notes'])
            ->setZipCode($data['address']['zip_code'])
            ->setStreet($data['address']['street'])
            ->setNumber($data['address']['number'])
            ->setComplement($data['address']['complement'])
            ->setNeighborhood($data['address']['neighborhood'])
            ->setCity($data['address']['city'])
            ->setState($data['address']['state']);

        $customerDAO->updateCustomer($customer);
        
        $response = $response->withJson([
            'id' => $customer->getUid(),
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone(),
            'person_type' => $customer->getPersonType(),
            'document' => $customer->getDocument(),
            'state_registration_number' => $customer->getStateRegistrationNumber(),
            'date_of_birth' => $customer->getDateOfBirth(),
            'notes' => $customer->getNotes(),
            'address' => array(
                'zip_code' => $customer->getZipCode(),
                'street' => $customer->getStreet(),
                'number' => $customer->getNumber(),
                'complement' => $customer->getComplement(),
                'neighborhood' => $customer->getNeighborhood(),
                'city' => $customer->getCity(),
                'state' => $customer->getState(),
            )
        ], 200);
        
        return $response;
        */
    }

    public function deleteFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $financialMovementDao = new FinancialMovementDAO();
            $financialMovements = $financialMovementDao->getFinancialMovementsId($args['id']);

            if ($financialMovements) {
                
                $financialMovementDao->deleteFinancialMovement($args['id']);
                
                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Movimento financeiro não encontrado"
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