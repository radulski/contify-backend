<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\CategoryDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Models\CategoryModel;
use App\Traits\UUID;
use App\Exceptions\ApiException;

final class CategoryController
{
    public function insertCategories(Request $request, Response $response, array $args): Response
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

            $categoryDao = new CategoryDAO();
            $category = new CategoryModel();
            
            $tenantId = $company['id'];

            $v4uuid = UUID::v4();

            $category->setName($data['name'])
                    ->setUid($v4uuid)
                    ->setTenantId($tenantId)
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUpdatedAt(date('Y-m-d H:i:s'));
            $categoryDao->insertCategory($category);
            
            return $response->withJson([
                'id' => $v4uuid,
                'name' => $category->getName(),
                'created_at' => $category->getCreatedAt(),
                'updated_at' => $category->getUpdatedAt()
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

    public function getCategories(Request $request, Response $response, array $args): Response
    {        
        try {
            $company_id = $args['company_id'];
            
            $page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;
            $limit = isset($_GET['size']) ? $_GET['size'] : 100;
            $offset = (--$page) * $limit;

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            foreach ($company as $line):
                $tenantId = $line['id'];
            endforeach;
            
            $categoriesDao = new CategoryDAO();
            $categories = $categoriesDao->getAllCategories($tenantId, $limit, $offset);
            $array = array();
            
            foreach ($categories as $line):
                $array[] = array(
                        "id"  => $line['uid'],
                        "name" => $line['name'],
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

    public function getCategoriesId(Request $request, Response $response, array $args): Response
    {        
        try {
            $company_id = $args['company_id'];
            $uid = $args['id'];
            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($company_id);

            if (!$company) {
                throw new ApiException("Company not found");
            }

            $categoriesDao = new CategoryDAO();
            $categories = $categoriesDao->getCategoriesId($uid);

            if (!$categories) {
                throw new ApiException("Category not found");
            }

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
    }

    public function updateCategories(Request $request, Response $response, array $args): Response
    {     
       try {
            $uid = $args['id'];
            $data = $request->getParsedBody();
            
            $categoryDAO = new CategoryDAO();
            $category = new CategoryModel();

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesId($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 

            $categoriesDao = new CategoryDAO();
            $categories = $categoriesDao->getCategoriesId($uid);

            if (!$categories) {
                throw new ApiException("Category not found");
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
    }

    public function deleteCategories(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $categoryDao = new CategoryDAO();
            $categories = $categoryDao->getCategoriesId($args['id']);

            if ($categories) {
                
                $categoryDao->deleteCategory($args['id']);
                
                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Category not found"
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