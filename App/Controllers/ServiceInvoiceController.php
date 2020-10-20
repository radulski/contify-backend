<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use App\DAO\MySQL\ContifyDev\ServiceInvoiceDAO;
use App\Models\ServiceInvoiceModel;
use App\DAO\MySQL\ContifyDev\ServiceInvoiceBatchDAO;
use App\Models\ServiceInvoiceBatchModel;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Exceptions\ApiException;

use App\Traits\UUID;

final class ServiceInvoiceController
{
    public function postFileServiceInvoice(Request $request, Response $response, array $args): Response
    {     
        try {
            $data = $request->getParsedBody();

            $companyDao = new CompanyDAO();
            $company = $companyDao->getCompaniesIdU($args['company_id']);

            if (!$company) {
                throw new ApiException("Company not found");
            } 
            if (empty(trim($data['year']))) {
                throw new ApiException("Year is required");
            }

            if (empty(trim($data['month']))) {
                throw new ApiException("Month is required");
            }

            if ($_FILES["file"]["tmp_name"][0] == "") {
                throw new ApiException("File is required");
            }
            
            $uploadedFiles = $request->getUploadedFiles();
            $data = $request->getParsedBody();
            $year = $data['year'];
            $month = $data['month'];

            $directory = '/Applications/MAMP/htdocs/api/uploads';
            $i = 0;

            $v4uuid = UUID::v4();

            //Lote notas fiscais
            $serviceInvoiceBatchDao = new ServiceInvoiceBatchDAO();
            $serviceInvoiceBatch = new ServiceInvoiceBatchModel();
            $serviceInvoiceBatch->setYearPurchase($year);
            $serviceInvoiceBatch->setMonthPurchase($month);
            $serviceInvoiceBatch->setUid($v4uuid);
            $serviceInvoiceBatch->setTenantId($company['id']);
            $idService = $serviceInvoiceBatchDao->insertServiceInvoiceBatch($serviceInvoiceBatch);
            
            foreach ($uploadedFiles['file'] as $uploadedFile) 
            {
                $arquivo = $_FILES["file"]["tmp_name"][$i];
                $nome    = $_FILES["file"]["name"][$i];
                $tamanho = $_FILES["file"]["size"][$i];
                $type    = $_FILES["file"]["type"][$i];

                if ($arquivo != "") {
                    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                    $basename = bin2hex(random_bytes(8));
                    
                    //$filename = sprintf('%s.%0.8s', $basename, $extension);
                    //$uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                    $fp = fopen($arquivo, "rb");
                    $conteudo = fread($fp, filesize($arquivo));
                    $conteudo = addslashes($conteudo);
                    fclose($fp);

                    $nome = addslashes($nome);
                    $dados = $conteudo;

                    $serviceInvoiceDao = new ServiceInvoiceDAO();
                    $serviceInvoice = new ServiceInvoiceModel();
                    $serviceInvoice->setBatchInvoiceId($idService);
                    $serviceInvoice->setTenantId($company['id']);
                    $serviceInvoiceDao->insertServiceInvoice($serviceInvoice, $dados, $type, $nome, $tamanho, $fp);
                }
            }

            //Retornar id do lote
            return $response->withJson([
                "id"  => $v4uuid
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

    public function getFileServiceInvoice(Request $request, Response $response, array $args): Response
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
            
            $serviceInvoiceDao = new ServiceInvoiceDAO();
            $batch = $serviceInvoiceDao->getAllBatchInvoices($tenantId);
            $array = array();
            
            foreach ($batch as $line):
                $array[] = array(
                        "id"  => $line['uid'],
                        "year" => $line['yearPurchase'],
                        "month" => $line['monthPurchase'],
                        "created_at" => $line['createdAt']
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

    public function deleteBatchInvoices(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['company_id']);
        
        if ($company) {
            $serviceInvoiceDao = new ServiceInvoiceDAO();
            $batch = $serviceInvoiceDao->getBatchId($args['id']);

            if ($batch) {
                
                $serviceInvoiceDao->deleteBatch($args['id']);
                
                $response = $response->withJson([
                    'deleted' => "true",
                    'id' => $args['id']
                ], 200);

            } else {
                $response = $response->withJson([
                    'errors' => array(
                        "message" => "Batch invoice not found"
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

    
    /*
    public function postFileServiceInvoice(Request $request, Response $response, array $args): Response
    {     
        $uploadedFiles = $request->getUploadedFiles();
        $data = $request->getParsedBody();

        $serviceinvoiceDao = new ServiceInvoiceDAO();
        $serviceInvoice = new ServiceInvoiceModel();

        $year = $data['year'];
        $month = $data['month'];
        $city = mb_strtoupper($data['city']);

        $directory = '/Applications/MAMP/htdocs/api/uploads';
        $i = 0;

        foreach ($uploadedFiles['file'] as $uploadedFile) 
        {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) 
            {                
                $tmp_name = $_FILES["file"]["tmp_name"][$i];

                //Validar arquivo
                $xml = simplexml_load_file( $tmp_name );
                
                //if ($city == "SÃO PAULO") {  
                    //$ns = $xml->getNamespaces(true);
                    //$child = $xml->children($ns['ns4']);

                    //$data_emissao = $child->InfNfse->DataEmissao;
                    //$competencia = $child->InfNfse->Competencia;

                    //$partes = explode("-", $competencia);
                    //$ano = $partes[0];
                    //$mes = $partes[1];

                    //Data não pode ser menor que a atual

                    //Validar ano e mês
                    
                    if ($year <> $ano) {
                        $response = array(
                            "errors" => array(
                                "message" => "Ano do corpo é diferente do xml.",
                                "field" => "name"
                            )
                        );
                        echo json_encode($response);
                        die;
                    }

                    if ($month <> $mes) {
                        
                    }
                    

                    //$numero = $child->InfNfse->Numero;
                    //$valor_servico = $child->InfNfse->Servico->Valores->ValorServicos;

                    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                    $basename = bin2hex(random_bytes(8));
                    $filename = sprintf('%s.%0.8s', $basename, $extension);

                    //Salvar banco
                   
                    $serviceInvoiceDao = new ServiceInvoiceDAO();
                    $serviceInvoice = new ServiceInvoiceModel();

                    $serviceInvoice->setNumber($numero);
                    $serviceInvoice->setTotalValue($valor_servico);
                    $serviceInvoice->setIssuanceDate($data_emissao);
                    
                    $serviceInvoiceDao->insertServiceInvoice($serviceInvoice);
                    

                    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
                    $response->write('uploaded ' . $filename . '<br/>');
                    $i++;
                //}
            }
        }
     
        //Retornar id do lote
        return $response;
    }
    */
}