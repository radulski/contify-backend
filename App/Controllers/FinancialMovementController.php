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

            $endDate = $args['endDate'];
            $initialDate = $args['initialDate'];

            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = $financialMovementDao->getAllFinancialMovements($tenantId);
            
            $categoryDao = new CategoryDAO();
            $categoryLaunchDao = new CategoryLaunchDAO();
            
            $array_categories = array();
            $array = array();
            
            foreach ($financialMovement as $line):
                $bankAccountDao = new BankAccountDAO();
                $bankAccount = $bankAccountDao->getBankAccountsUid($line['bankAccountId']);
                            
                $categoryLaunch = $categoryLaunchDao->getCategoriesLaunchId($line['id']);

                foreach ($categoryLaunch as $linec):            
                    $category_id = $categoryDao->getCategoriesId2($linec['categoryId']);
                    
                    $array_categories[] = array(
                        "id"  => $linec['uid'],
                        "category_id" => $category_id['uid'],
                        "value" => $linec['value']
                    );
                endforeach;

                $dateLaunch = date('Y-m-d', strtotime($line['date']));

                $array[] = array(
                    "id"  => $line['uid'],
                    "customer_id" => $line['contact_id'],
                    "bank_account_id" => $bankAccount['uid'],
                    "movement_type" => $line['type'],
                    "date" => $dateLaunch,
                    "notes" => $line['description'],
                    "categories" =>
                        $array_categories
                );

                unset($array_categories);
            endforeach;

            return $response->withJson($array, 200); 
        
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

    public function getFinancialMovementId(Request $request, Response $response, array $args): Response
    {   
        try {
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = $financialMovementDao->getFinancialMovementsId($uid);

            if (!$financialMovement) {
                throw new ApiException("Financial movement not found");
            }

            $array_categories = array();
            $array = array();

            $categoryDao = new CategoryDAO();
            $categoryLaunchDao = new CategoryLaunchDAO();

            foreach ($financialMovement as $line):
                
                $categoryLaunch = $categoryLaunchDao->getCategoriesLaunchId($line['id']);
                foreach ($categoryLaunch as $linec):            
                    $category_id = $categoryDao->getCategoriesId2($linec['categoryId']);
                    
                    $array_categories[] = array(
                        "id"  => $linec['uid'],
                        "category_id" => $category_id['uid'],
                        "value" => $linec['value']
                    );
                endforeach;
                
                $bankAccountDao = new BankAccountDAO();
                $bankAccount = $bankAccountDao->getBankAccountsUid($line['bankAccountId']);
                
                $dateLaunch = date('Y-m-d', strtotime($line['date']));

                $array = array(
                        "id"  => $line['uid'],
                        "customer_id" => $line['contact_id'],
                        "bank_account_id" => $bankAccount['uid'],
                        "movement_type" => $line['type'],
                        "date" => $dateLaunch,
                        "notes" => $line['description'],
                        "categories" =>
                            $array_categories
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

            foreach($data['categories'] as $dados) {          
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
                    ->setTransferId(null)
                    ->setMovementType($data['movement_type']);
                            
            $launch_id = $financialMovementDao->insertFinancialMovement($financialMovement);
            
            $array2 = array();

            foreach($data['categories'] as $dados) {     
                $v4uuidCategory = UUID::v4();
                
                //pegar id da categoria pelo uid
                $category_id = $financialMovementDao->getCategoryId($dados['category_id']);
                
                $category = (new CategoryLaunchModel())->setCategoryId($category_id['id'])
                            ->setUid($v4uuidCategory)                    
                            ->setValue($dados['value'])
                            ->setTenantId($tenantId)
                            ->setLaunchid($launch_id); 
                $categoryDao = (new CategoryLaunchDao())->insertCategoriesLaunch($category);

                $array2[] = array(
                    "id" => $v4uuidCategory,
                    "category_id" => $dados['category_id'],
                    "value" => $dados['value']
                );
            }

            $array = array(
                'id' => $financialMovement->getUid(),
                'customer_id' => $data['customer_id'],
                'bank_account_id' => $data['bank_account_id'],
                'movement_type' => $financialMovement->getMovementType(),
                'date' => $financialMovement->getDate(),
                'notes' => $financialMovement->getNotes(),
                'created_at' => $financialMovement->getCreatedAt(),
                'updated_at' => $financialMovement->getUpdatedAt(),
                "categories" => 
                    $array2
            );
        
            return $response->withJson($array, 201); 

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

    public function updateFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        try {
            $uid = $args['id'];
            $data = $request->getParsedBody();
            
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            $financialMovementsDao = new FinancialMovementDAO();
            $financialMovemens = $financialMovementsDao->getFinancialMovementsId($uid);

            if (!$financialMovemens) {
                throw new ApiException("Financial Movements not found");
            }

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            if (!empty(trim($data['customer_id']))) {
                $customerDao = new CustomerDAO();
                $customer = $customerDao->getCustomersId($data['customer_id']);
                if (!$customer) {
                    throw new ApiException("Customer not found");
                } 
            }

            if (!empty(trim($data['bank_account_id']))) {
                $bankAccountDao = new BankAccountDAO();
                $bankAccount = $bankAccountDao->getBankAccountsId($data['bank_account_id']);
                if (!$bankAccount) {
                    throw new ApiException("Bank Account not found");
                } 
            }

            $launch_id_int22 = $financialMovementsDao->getFinancialMovementsId($uid);
            
            foreach ($launch_id_int22 as $line):
                $idLaunchCat = $line['id'];
            endforeach;

            $categoryLaunchDao = new CategoryLaunchDAO();

            foreach($data['categories'] as $dados){          
                $categoryId = isset($dados['category_id']) ? $dados['category_id'] : null;
                $categoryValue = isset($dados['value']) ? $dados['value'] : null;

                $categoryDao = new CategoryDAO();
                $category = $categoryDao->getCategoriesId($dados['category_id']);

                //Verificar se o id da categoryLaunch existe
                if (!empty(trim($dados['id']))) {
                    $categoryLaunchId = $categoryLaunchDao->getCategoriesLaunchUid3($dados['id'], $idLaunchCat);
                    if (!$categoryLaunchId) {
                        throw new ApiException("Category id not found");
                    }
                }
                
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

            //categorias cadastradas tabela
            $vetor = array();
            
            /*
            $sql_lista_uids_category_launch = $categoryLaunchDao->getCategoriesLaunchId($idLaunchCat);
            $i = 1;
            foreach ($sql_lista_uids_category_launch as $line):                            
                $vetor[$i] = $line['uid']; 
                $i++;
            endforeach;
            */

            $i = 1;
            foreach($data['categories'] as $dados) {  
                //salvar array
                if ($dados['id'] != "") {
                    $vetor[$i] = $dados['id']; 
                    $i++;
                }
            }

            //Excluir do banco o que for diferente do json
            $categoryLaunchDao->deleteCategoriesLaunchUpdate($vetor, $idLaunchCat);

            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = new FinancialMovementModel();
            
            $tenantId = $company['id'];

            $financialMovement->setUid($v4uuid)
                    ->setTenantId($tenantId)
                    ->setUpdatedAt(date('Y-m-d H:i:s'))
                    ->setContactId($customer['id'])
                    ->setDate($data['date'])
                    ->setBankAccountId($bankAccount['id'])
                    ->setBankAccountUid($data['bank_account_id'])
                    ->setNotes($data['notes'])
                    ->setTransferId(null)
                    ->setUid($uid)
                    ->setMovementType($data['movement_type']);

            $launch_id = $financialMovementDao->updateFinancialMovement($financialMovement);

            $launch_id_int = $financialMovementDao->getFinancialMovementsId($uid);
            
            foreach ($launch_id_int as $line):
                $idl = $line['id'];
            endforeach;

            $array2 = array();

            foreach($data['categories'] as $dados) {    

                $v4uuidCat = UUID::v4();

                //pegar id da categoria pelo uid
                $category_id = $financialMovementDao->getCategoryId($dados['category_id']);
                
                if (empty(trim($dados['id']))) {
                    $incrementUid = UUID::v4();
                } else {
                    $incrementUid = $dados['id'];
                }

                $category = (new CategoryLaunchModel())->setCategoryId($category_id['id'])
                            ->setUid($incrementUid)                    
                            ->setValue($dados['value'])
                            ->setCategoryId($category_id['id'])
                            //->setUid($dados['id'])
                            ->setLaunchid($idl)
                            ->setTenantId($tenantId);
                
                //caso não tenha id da categoria no item, fazer inserção
                if (empty(trim($dados['id']))) {                    
                    $categoryDao = (new CategoryLaunchDao())->insertCategoriesLaunch($category);
                } else {
                    $categoryDao = (new CategoryLaunchDao())->updateCategoriesLaunch($category);
                }

                $array2[] = array(
                    "id" => $incrementUid,
                    "category_id" => $dados['category_id'],
                    "value" => $dados['value']
                );
            }

            $array = array(
                'id' => $financialMovement->getUid(),
                'customer_id' => $data['customer_id'],
                'bank_account_id' => $data['bank_account_id'],
                'movement_type' => $financialMovement->getMovementType(),
                'date' => $financialMovement->getDate(),
                'notes' => $financialMovement->getNotes(),
                //'created_at' => $financialMovement->getCreatedAt(),
                'updated_at' => $financialMovement->getUpdatedAt(),
                "categories" => 
                    $array2
            );

            return $response->withJson($array, 200); 
            
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

    public function deleteFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $financialMovementDao = new FinancialMovementDAO();
            $financialMovements = $financialMovementDao->getFinancialMovementsId($args['id']);

            if ($financialMovements) {
                
                $launch_id = $args['id'];
                $financialMovements1 = $financialMovementDao->getFinancialMovementsId($launch_id);

                foreach ($financialMovements1 as $line):
                    $idl = $line['id'];
                endforeach;

                $financialMovementDao->deleteFinancialMovement($args['id']);
                
                $categoryLaunchDao = new CategoryLaunchDAO();
                $categoryLaunchDao->deleteCategoriesLaunch($idl);

                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Financial movement not found"
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

    public function insertCategoriesFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        try {
            $financial_movement_uid = $args['id'];
            
            $data = $request->getParsedBody();
            
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 
            
            $categoryDao = new CategoryDAO();
            $category = $categoryDao->getCategoriesId($data['category_id']);
            if (!$category) {
                throw new ApiException("Category not found");
            } 

            if (empty(trim($data['value']))) {
                throw new ApiException("Value is required");
            }

            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = new FinancialMovementModel();
            
            $tenantId = $company['id'];
            $v4uuid = UUID::v4();

            $financialMovement1 = $financialMovementDao->getFinancialMovementsId($financial_movement_uid);

            if (!$financialMovement1) {
                throw new ApiException("Financial Movements not found");
            }

            foreach ($financialMovement1 as $line):        
                $launch_id = $line['id'];
            endforeach;

            $financialMovement->setValue($data['value'])
                    ->setUid($v4uuid)
                    ->setCategoryId($category['id'])
                    ->setEnable(1)
                    ->setTenantId($tenantId)
                    ->setLaunchId($launch_id)
                    ->setCreatedAt(date('Y-m-d H:i:s'));
                    
            $launch_id = $financialMovementDao->insertFinancialMovementCategories($financialMovement);
            
            return $response->withJson([
                'id' => $v4uuid,
                'category_id' => $data['category_id'],
                'value' => $financialMovement->getValue()
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

    public function getCategoriesFinancialMovementId(Request $request, Response $response, array $args): Response
    {   
        try {
            $data = $request->getParsedBody();
            
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $financialMovementCategoryDao = new CategoryLaunchDAO();
            $financialMovement = $financialMovementCategoryDao->getCategoriesLaunchUid($uid);

            if (!$financialMovement) {
                throw new ApiException("Category financial movement not found");
            }
            
            $array = array();

            $categoryDao = new CategoryDAO();

            foreach ($financialMovement as $line):  
                $category_id = $categoryDao->getCategoriesUid($line['categoryId']);

                $array = array(
                        "id"  => $line['uid'],
                        "category_id" => $category_id['uid'],
                        "value" => $line['value']
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

    public function getCategoriesFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        try {
            $data = $request->getParsedBody();
            
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $financialMovementDao = new FinancialMovementDAO();
            $financialMovement = $financialMovementDao->getFinancialMovementsId($uid);

            if (!$financialMovement) {
                throw new ApiException("Financial Movements not found");
            }

            $launch_id = $args['id'];
            $financialMovements1 = $financialMovementDao->getFinancialMovementsId($launch_id);
            
            foreach ($financialMovements1 as $line):
                $idl = $line['id'];
            endforeach;

            $categoryLaunchDao = new CategoryLaunchDAO();
            $categoryLaunch = $categoryLaunchDao->getCategoriesLaunchId($idl);

            foreach ($categoryLaunch as $line):            
                $array[] = array(
                    "id"  => $line['uid'],
                    "category_id" => $line['uid'],
                    "value" => $line['value']
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

    public function deleteCategoriesFinancialMovement(Request $request, Response $response, array $args): Response
    {   
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        $uidm = $args['idm'];

        if ($company) {
            $financialMovementDao = new FinancialMovementDAO();
            $financialMovements = $financialMovementDao->getFinancialMovementsId($args['id']);

            if ($financialMovements) {


                $financialMovementCategoryDao = new CategoryLaunchDAO();
                $financialMovementC = $financialMovementCategoryDao->getCategoriesLaunchUid($uidm);

                if ($financialMovementC) {

                    //deletar categoryLaunch
                    $launch_id = $args['id'];
                    $financialMovements1 = $financialMovementDao->getFinancialMovementsId($launch_id);
    
                    foreach ($financialMovements1 as $line):
                        $idl = $line['id'];
                    endforeach;
                    
                    $categoryLaunchDao = new CategoryLaunchDAO();
                    $categoryLaunchDao->deleteCategoriesLaunchId($args['idm']);

                    $response = $response->withJson([
                        'deleted' => "true",
                        'id' => $args['id']
                    ], 200);  
                      
                } else {
                    $response = $response->withJson([
                        'errors' => array(
                            "message" => "Category financial movement not found"
                        )
                    ], 422);
                }        

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Financial movement not found"
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