<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use App\DAO\MySQL\ContifyDev\CustomerDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Models\CustomerModel;
use App\Traits\UUID;
use App\Exceptions\ApiException;

final class CustomerController
{    
    public function getCustomers(Request $request, Response $response, array $args): Response
    {        
        try {
            $company_id = $args['company_id'];
            
            $page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;
            $limit = isset($_GET['size']) ? $_GET['size'] : 100;
            $offset = (--$page) * $limit;

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }
            
            $customersDao = new CustomerDAO();
            $customers = $customersDao->getAllCustomers($company['id'], $limit, $offset);
            $array = array();
            
            foreach ($customers as $line):
                $array[] = array(
                        "id"  => $line['uid'],
                        "name" => $line['name'],
                        "email" => $line['email'],
                        "phone" => $line['phone'],
                        "person_type" => $line['pfpj'],
                        "document" => $line['cpfCnpj'],
                        "state_registration_number" => $line['stateRegistration'],
                        "date_of_birth" => $line['birth'],
                        "notes" => $line['note'],
                        "zip_code" => $line['cep'],
                        "address" => array(
                            "street" => $line['address'],
                            "number" => $line['number'],
                            "complement" => $line['complement'],
                            "neighborhood" => $line['district'],
                            "city" => $line['city'],
                            "state" => $line['state']
                        )
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

    public function getCustomersId(Request $request, Response $response, array $args): Response
    {                  
        try {
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $customersDao = new CustomerDAO();
            $customers = $customersDao->getCustomersId($uid);

            if (!$customers) {
                throw new ApiException("Customer not found");
            }

            return $response->withJson([
                "id"  => $customers['uid'],
                "name" => $customers['name'],
                "email" => $customers['email'],
                "phone" => $customers['phone'],
                "person_type" => $customers['pfpj'],
                "document" => $customers['cpfCnpj'],
                "state_registration_number" => $customers['stateRegistration'],
                "date_of_birth" => $customers['birth'],
                "notes" => $customers['note'],
                "zip_code" => $customers['cep'],
                "address" => array(
                    "street" => $customers['address'],
                    "number" => $customers['number'],
                    "complement" => $customers['complement'],
                    "neighborhood" => $customers['district'],
                    "city" => $customers['city'],
                    "state" => $customers['state']
                )
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

    public function insertCustomers(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            if (empty(trim($data['name']))) {
                throw new ApiException("Name is required");
            }

            $customerDao = new CustomerDAO();
            $customer = new CustomerModel();
            
            $tenantId = $company['id'];

            $v4uuid = UUID::v4();

            $customer->setName($data['name'])
                    ->setUid($v4uuid)
                    ->setTenantId($tenantId)
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUpdatedAt(date('Y-m-d H:i:s'))
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

            $customerDao->insertCustomer($customer);
            
            return $response->withJson([
                'id' => $v4uuid,
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'created_at' => $customer->getCreatedAt(),
                'updated_at' => $customer->getUpdatedAt(),
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
                    'state' => $customer->getState()
                )
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

    public function updateCustomers(Request $request, Response $response, array $args): Response
    {     
        try {
            $uid = $args['id'];
            $data = $request->getParsedBody();
            
            $customerDAO = new CustomerDAO();
            $customer = new CustomerModel();

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            $customersDao = new CustomerDAO();
            $customers = $customersDao->getCustomersId($uid);

            if (!$customers) {
                throw new ApiException("Customer not found");
            }

            if (!$data){
                return $response->withJson([
                    "id"  => $customers['uid'],
                    "name" => $customers['name'],
                    "email" => $customers['email'],
                    "created_at" => $customers['createdAt'],
                    "updated_at" => $customers['updatedAt'],
                    "phone" => $customers['phone'],
                    "person_type" => $customers['pfpj'],
                    "document" => $customers['cpfCnpj'],
                    "state_registration_number" => $customers['stateRegistration'],
                    "date_of_birth" => $customers['birth'],
                    "notes" => $customers['note'],
                    "address" => array(
                        "zip_code" => $customers['cep'],
                        "street" => $customers['address'],
                        "number" => $customers['number'],
                        "complement" => $customers['complement'],
                        "neighborhood" => $customers['district'],
                        "city" => $customers['city'],
                        "state" => $customers['state']
                    )
                ], 200); 
                
                die;
            }

            if (empty(trim($data['name']))) {
                throw new ApiException("Name is required");
            }
            
            $customer->setName($data['name'])
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
            
            //selecionar customer após atualização
            $customers = $customersDao->getCustomersId($uid);

            return $response->withJson([
                "id"  => $customers['uid'],
                "name" => $customers['name'],
                "email" => $customers['email'],
                "phone" => $customers['phone'],
                "person_type" => $customers['pfpj'],
                "document" => $customers['cpfCnpj'],
                "state_registration_number" => $customers['stateRegistration'],
                "date_of_birth" => $customers['birth'],
                "notes" => $customers['note'],
                "address" => array(
                    "zip_code" => $customers['cep'],
                    "street" => $customers['address'],
                    "number" => $customers['number'],
                    "complement" => $customers['complement'],
                    "neighborhood" => $customers['district'],
                    "city" => $customers['city'],
                    "state" => $customers['state']
                )
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

    public function deleteCustomers(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $customerDao = new CustomerDAO();
            $customers = $customerDao->getCustomersId($args['id']);

            if ($customers) {
                
                $customerDao->deleteCustomer($args['id']);
                
                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Customer not found"
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