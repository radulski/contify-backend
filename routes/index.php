<?php

use function src\slimConfiguration;
use function src\basicAuth;
use App\Controllers\ProductController;
use App\Controllers\CustomerController;
use App\Controllers\ServiceInvoiceController;
use App\Controllers\FinancialMovementController;
use App\Controllers\CompanyController;
use App\Controllers\BankAccountController;
use App\Controllers\CategoryController;
use App\Controllers\TransferController;
use App\Controllers\TaxGuideController;
use App\Controllers\AttachmentController;
use App\Controllers\LoginController;
use App\Controllers\EmployeeController;
use App\Controllers\IntegrationController;
use Tuupola\Middleware\HttpBasicAuthentication;
use thiagoalessio\TesseractOCR\TesseractOCR;

use Slim\Views\PhpRenderer;

$container = new \Slim\Container(); 

$app = new \Slim\App(slimConfiguration());
//$view = new \Slim\Views\PhpRenderer('management/templates/views/');

$renderer = new PhpRenderer('management/templates/views');

//$view = PhpRenderer('management/templates/views');
// Substituir o manipulador não encontrado padrão após o aplicativo

unset($app->getContainer()['notFoundHandler']);
$app->getContainer()['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        $response = new \Slim\Http\Response(404);
        return $response->withJson([
            'errors' => 'Page not found'
        ], 404);
    };
};

// error_reporting(-1); 
// ini_set('display_errors', 1); 

// Ambiente Produção
/*
$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["https://contify-ui.herokuapp.com"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
    "headers.expose" => ["Etag"],
    "credentials" => true,
    "cache" => 86400
]));
*/

// Ambiente Local
/*
$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["http://localhost:4200"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
    "headers.expose" => ["Etag"],
    "credentials" => true,
    "cache" => 86400
]));
*/

$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["http://localhost:4200"],
    "methods" => ["GET", "POST", "PATCH", "DELETE", "OPTIONS"],    
    "headers.allow" => ["Origin", "Content-Type", "Authorization", "Accept", "ignoreLoadingBar", "X-Requested-With", "Access-Control-Allow-Origin"],
    "headers.expose" => [],
    "credentials" => true,
    "cache" => 0,        
]));

$app->group('', function() use ($app) { 
    
    /**
     * Grupo dos enpoints iniciados por v1
     */
    
    $app->group('/v1', function() {
        
        $this->group('/companies', function() {
            $this->post('', CompanyController::class . ':insertCompanies'); 
            $this->get('', CompanyController::class . ':getCompanies'); 
            $this->get('/{id}', CompanyController::class . ':getCompaniesId'); 
            $this->get('/{id}/partners', CompanyController::class . ':getPartnersCompanies'); 
            $this->delete('/{id}', CompanyController::class . ':deleteCompanies'); 
            
            $this->post('/{company_id}/customers', CustomerController::class . ':insertCustomers'); 
            $this->get('/{company_id}/customers', CustomerController::class . ':getCustomers'); 
            $this->get('/{company_id}/customers/{id}', CustomerController::class . ':getCustomersId'); 
            $this->put('/{company_id}/customers/{id}', CustomerController::class . ':updateCustomers'); 
            $this->delete('/{company_id}/customers/{id}', CustomerController::class . ':deleteCustomers'); 
            
            $this->post('/{company_id}/bank_accounts', BankAccountController::class . ':insertBankAccounts');
            $this->get('/{company_id}/bank_accounts', BankAccountController::class . ':getBankAccounts');
            $this->get('/{company_id}/bank_accounts/{id}', BankAccountController::class . ':getBankAccountsId');
            $this->put('/{company_id}/bank_accounts/{id}', BankAccountController::class . ':updateBankAccounts');
            $this->delete('/{company_id}/bank_accounts/{id}', BankAccountController::class . ':deleteBankAccounts'); 

            $this->post('/{company_id}/categories', CategoryController::class . ':insertCategories');
            $this->get('/{company_id}/categories', CategoryController::class . ':getCategories');
            $this->get('/{company_id}/categories/{id}', CategoryController::class . ':getCategoriesId');
            $this->put('/{company_id}/categories/{id}', CategoryController::class . ':updateCategories');
            $this->delete('/{company_id}/categories/{id}', CategoryController::class . ':deleteCategories'); 

            $this->post('/{company_id}/financial_movements', FinancialMovementController::class . ':insertFinancialMovement'); 
            $this->get('/{company_id}/financial_movements', FinancialMovementController::class . ':getFinancialMovement'); 
            $this->get('/{company_id}/financial_movements/{id}', FinancialMovementController::class . ':getFinancialMovementId'); 
            $this->put('/{company_id}/financial_movements/{id}', FinancialMovementController::class . ':updateFinancialMovement');
            $this->delete('/{company_id}/financial_movements/{id}', FinancialMovementController::class . ':deleteFinancialMovement');

            $this->post('/{company_id}/batch_invoices', ServiceInvoiceController::class . ':postFileServiceInvoice');
            $this->get('/{company_id}/batch_invoices', ServiceInvoiceController::class . ':getFileServiceInvoice');
            $this->delete('/{company_id}/batch_invoices/{id}', ServiceInvoiceController::class . ':deleteBatchInvoices');

            $this->get('/{company_id}/tax_guide[/{year}[/{month}]]', TaxGuideController::class . ':getTaxGuide');

             //Categorias do movimento financeiro
            
            $this->get('/{company_id}/transfers', TransferController::class . ':getTransfers');
            $this->get('/{company_id}/transfers/{id}', TransferController::class . ':getTransfersId');
            $this->post('/{company_id}/transfers', TransferController::class . ':insertTransfers');
            $this->delete('/{company_id}/transfers/{id}', TransferController::class . ':deleteTransfers'); 

            //criar
            $this->post('/{company_id}/financial_movements/{id}/financial_movement_categories', FinancialMovementController::class . ':insertCategoriesFinancialMovement'); 

            //buscar id
            $this->get('/{company_id}/financial_movement_categories/{id}', FinancialMovementController::class . ':getCategoriesFinancialMovementId'); 

            //listar todas
            $this->get('/{company_id}/financial_movements/{id}/financial_movement_categories', FinancialMovementController::class . ':getCategoriesFinancialMovement'); 

            //excluir 
            $this->delete('/{company_id}/financial_movements/{id}/financial_movement_categories/{idm}', FinancialMovementController::class . ':deleteCategoriesFinancialMovement'); 

            $this->post('/{company_id}/service_invoices', ServiceInvoiceController::class . ':postFileServiceInvoice');

            //Login
            $this->get('/{company_id}/login', LoginController::class . ':login');   
            
            // Funcionário
            $this->post('/{company_id}/employees', EmployeeController::class . ':insertEmployees'); 
            $this->get('/{company_id}/employees', EmployeeController::class . ':getEmployees'); 
            $this->get('/{company_id}/employees/{id}', EmployeeController::class . ':getEmployeesId'); 
            $this->put('/{company_id}/employees/{id}', EmployeeController::class . ':updateEmployees'); 
            $this->delete('/{company_id}/employees/{id}', EmployeeController::class . ':deleteEmployees'); 
            
            // Logout
            $this->delete('/{company_id}/tokens/revoke', LoginController::class . ':revokeToken');
            $this->post('/{company_id}/login/generate_token', LoginController::class . ':generateToken');
            $this->post('/{company_id}/attachment', AttachmentController::class . ':insertAttachment');

            //integração Questor
            $this->post('/insert_integration_companies', IntegrationController::class . ':insertIntegrationCompanies');
        });
    })->add(basicAuth());
});

$app->run();
