<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\DAO\MySQL\ContifyDev\EmployeeDAO;
use App\Models\EmployeeModel;
use App\Traits\UUID;
use App\Exceptions\ApiException;

final class EmployeeController
{    
    public function getEmployees(Request $request, Response $response, array $args): Response
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
            
            $employeeDao = new EmployeeDAO();
            $employees = $employeeDao->getAllEmployees($company['id'], $limit, $offset);
            $arrayContent = array();
            
            foreach ($employees as $line):
                $arrayContent[] = array(
                    "id"  => $line['uid'],
                    "name" => $line['fullName'],
                    "admissionDate" => $line['admissionDate']
                 );  
            endforeach;

            $array = array(
                "content" => $arrayContent,
                "totalElements" => count($arrayContent)
            );
            
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

    public function getEmployeesId(Request $request, Response $response, array $args): Response
    {                  
        try {
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $employeeDao = new CustomerDAO();
            $employees = $employeeDao->getEmployeesId($uid);

            if (!$employees) {
                throw new ApiException("Employee not found");
            }

            return $response->withJson([
                "id"  => $employees['uid'],
                "name" => $employees['name']
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

    public function insertEmployees(Request $request, Response $response, array $args): Response
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

            if (empty(trim($data['salary']))) {
                throw new ApiException("Salary is required");
            }

            if (empty(trim($data['admissionDate']))) {
                throw new ApiException("Admission Date is required");
            }

            if (empty(trim($data['startTimeStartPeriodMonToFri']))) {
                throw new ApiException("Start Time Start Period Mon To Fri is required");
            }

            $startTimeStartPeriodMonToFri = $data["startTimeStartPeriodMonToFri"];
            $endTimeStartPeriodMonToFri = $data["endTimeStartPeriodMonToFri"];
            $startTimeEndPeriodMonToFri = $data["startTimeEndPeriodMonToFri"]; 
            $endTimeEndPeriodMonToFri = $data["endTimeEndPeriodMonToFri"]; 
            $startTimeSaturday = $data["startTimeSaturday"]; 
            $endTimeSaturday = $data["endTimeSaturday"]; 

            if (strlen($startTimeStartPeriodMonToFri) == 4) {
                $startTimeStartPeriodMonToFri = substr_replace($startTimeStartPeriodMonToFri, ':', 2, 0);
            }   

            if (strlen($endTimeStartPeriodMonToFri) == 4) {
                $endTimeStartPeriodMonToFri = substr_replace($endTimeStartPeriodMonToFri, ':', 2, 0);
            }   

            if (strlen($startTimeEndPeriodMonToFri) == 4) {
                $startTimeEndPeriodMonToFri = substr_replace($startTimeEndPeriodMonToFri, ':', 2, 0);
            }   

            if (strlen($endTimeEndPeriodMonToFri) == 4) {
                $endTimeEndPeriodMonToFri = substr_replace($endTimeEndPeriodMonToFri, ':', 2, 0);
            }   

            if (strlen($startTimeSaturday) == 4) {
                $startTimeSaturday = substr_replace($startTimeSaturday, ':', 2, 0);
            }   

            if (strlen($endTimeSaturday) == 4) {
                $endTimeSaturday = substr_replace($endTimeSaturday, ':', 2, 0);
            }   

    
            $admissionDate = substr($data['admissionDate'], 0, 10);

            $employeeDao = new EmployeeDAO();
            $employee = new EmployeeModel();
            
            $tenantId = $company['id'];

            $v4uuid = UUID::v4();

            $employee->setFullName($data['name'])
                    ->setUid($v4uuid)
                    ->setTenantId($tenantId)
                    ->setSalary($data['salary'])
                    ->setAdmissionDate($admissionDate)
                    ->setStartTimeStartPeriodMonToFri($startTimeStartPeriodMonToFri)
                    ->setEndTimeStartPeriodMonToFri($endTimeStartPeriodMonToFri)
                    ->setStartTimeEndPeriodMonToFri($startTimeEndPeriodMonToFri)
                    ->setEndTimeEndPeriodMonToFri($endTimeEndPeriodMonToFri)
                    ->setStartTimeSaturday($startTimeSaturday)
                    ->setEndTimeSaturday($endTimeSaturday)
                    ->setCreatedAt(date('Y-m-d H:i:s'));

            $employeeDao->insertEmployees($employee);
            
            return $response->withJson([
                'id' => $v4uuid,
                'name' => $employee->getFullName(),
                'created_at' => $employee->getCreatedAt()
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

    public function deleteEmployees(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $employeeDao = new EmployeeDAO();
            $employees = $customerDao->getEmployeesId($args['id']);

            if ($employees) {
                
                $employeeDao->deleteEmployees($args['id']);
                
                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Employee not found"
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

    public function anexo(Request $request, Response $response): String {
        $files = $request->getUploadedFiles();
        $newfile = $files['arquivo'];
        $uploadFileName = $newfile->getClientFilename();
        $fileSize = $newfile->getSize();
        $fileType = $newfile->getClientMediaType();

        return $fileType;
    }
}