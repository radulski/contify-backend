<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\DAO\MySQL\ContifyDev\PartnerDAO;
use App\DAO\MySQL\ContifyDev\TokenDAO;
use App\DAO\MySQL\ContifyDev\TaxRegimeDAO;
use App\Models\CompanyModel;
use App\Models\PartnerModel;
use App\Models\TokenModel;

use App\Models\IntegrationModel;
use App\DAO\MySQL\ContifyDev\IntegrationDAO;

use App\Traits\UUID;
use App\Exceptions\ApiException;

use App\Services\CompanyService;

final class CompanyController
{ 
    public function insertCompanies(Request $request, Response $response, array $args): Response
    {
        try { 
            $params = $request->getParsedBody();
            $tokenId = $_SERVER['PHP_AUTH_PW'];
            $tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

            if ($tokenType == "TEST_") {
                $tokenId = substr($_SERVER['PHP_AUTH_PW'], 5);
            }

            $token = new TokenDAO();
            $responseToken = $token->getTokenId($tokenId);

            if ($responseToken) {
                $token_id = $responseToken['id'];
            }
            
            $v4uuid = UUID::v4();
            $data_url = file_get_contents("php://input");
            $data = json_decode($data_url); 
            
            $name = isset($data->name) ? $data->name : null;
            $document = isset($data->document) ? $data->document : null;
            $tax_regime = isset($data->tax_regime) ? $data->tax_regime : null;

            foreach ($data->partners as $dados){
                $partnerName = isset($dados->name) ? $dados->name : null;
                $partnerDocument = isset($dados->document) ? $dados->document : null;

                if (!$partnerName) {
                    throw new ApiException("Name of partner business is required");
                }
                if (!$partnerDocument) {
                    throw new ApiException("Partner's document is required");
                }
            }

            if (!$name) {
                throw new ApiException("Name is required");
            }

            if (!$document) {
                throw new ApiException("Document (CNPJ) is required");
            }

            if (!$tax_regime) {
                throw new ApiException("Tax regime is required");
            }

            $taxRegimeDao = new TaxRegimeDAO();
            $taxRegime = $taxRegimeDao->getTaxRegime($tax_regime);
            
            if (empty($taxRegime)) {
                throw new ApiException("Tax regime is not valid");
            }
            
            $integration = (new IntegrationModel())->setIntegrated(false)
                            ->setIntegratedAt(date('Y-m-d H:i:s'))
                            ->setTableName('tenant');

            $integrationId = (new IntegrationDAO())->insertIntegration($integration);
            
            $company = (new CompanyModel())->setName($data->name)
                        ->setUid($v4uuid)
                        ->setDocument($data->document)
                        ->setTaxRegime($taxRegime["id"])
                        ->setIntegrationId($integrationId);
            
            $tenantId = (new CompanyDao())->insertCompanies($company, $token_id);
            
            // Sócios da empresa
            foreach ($data->partners as $dados){
                $v4uuidParner = UUID::v4();  
                
                $integration = (new IntegrationModel())->setIntegrated(false)
                            ->setIntegratedAt(date('Y-m-d H:i:s'))
                            ->setTableName('partner');

                $integrationId = (new IntegrationDAO())->insertIntegration($integration);

                $partner = (new PartnerModel())->setDocument($dados->document)
                            ->setUid($v4uuidParner)                    
                            ->setName($dados->name)
                            ->setDocument($dados->document)
                            ->setJobDescription($dados->job_description)
                            ->setZipCode($dados->zip_code)
                            ->setStreet($dados->street)
                            ->setNumber($dados->number)
                            ->setComplement($dados->complement)
                            ->setNeighborhood($dados->neighborhood)
                            ->setCity($dados->city)
                            ->setState($dados->state)
                            ->setPhone($dados->phone)
                            ->setTenantId($tenantId)
                            ->setIntegrationId($integrationId);   
                $partnerDao = (new PartnerDao())->insertPartners($partner); 
            }

            // Estabelecimento
            /*
            $companyLayout[] = array(
                "nome" => "Empresa.nli",
                "arquivo" => $base64CompanyFile
            );

            $companyArray = [
                "leiautes"  => $companyLayout,
                "filtro" => "",
                "dados" => $base64Data,
                "podealterardados" => false,
                "executarvalidacaofinal" => false
            ];
            
            $jsonQuestor = json_encode($companyArray);
            */
            
            /*
            // Partner array
            $partnerLayout[] = array(
                "nome" => "Socio.nli",
                "arquivo" => $base64PartnerFile
            );

            $partnerArray = [
                "leiautes"  => $partnerLayout,
                "filtro" => "",
                "dados" => $base64DataParner,
                "podealterardados" => false,
                "executarvalidacaofinal" => false
            ];

            $jsonPartnerQuestor = json_encode($partnerArray);
            
            // echo $jsonPartnerQuestor;
            // echo $jsonQuestor;
            
            // Curl Empresa
            $curl = curl_init("http://cazraps01.brazilsouth.cloudapp.azure.com:8080/integracao/importar"); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonQuestor);
            $curl_response = curl_exec($curl);

            if (curl_errno($ch)) {
                echo 'Request Error:' . curl_error($curl);
            }
           
            //echo $curl_response;
            curl_close($curl);

            // Curl Sócio       
            $curl = curl_init("http://cazraps01.brazilsouth.cloudapp.azure.com:8080/integracao/importar"); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonPartnerQuestor);
            $curl_response = curl_exec($curl);
            
            echo $curl_response;

            // ler json e pegar código do sócio no questor
            // $obj = json_decode($curl_response);
            
            // foreach ($obj->linhas as $dadosRetorno) {
                // echo 'chave: ' . $dadosRetorno->chave;
            // }

            if (curl_errno($ch)) {
                echo 'Request Error:' . curl_error($curl);
            }
            */

            return $response->withJson([
                'id' => $v4uuid,
                'name' => $company->getName(),
                'document' => $company->getDocument(),
                'tax_regime' => strtoupper($taxRegime["name"])
            ], 201); 

            // Enviar dados Questor
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

    /*
    public function insertCompanies(Request $request, Response $response, array $args): Response
    {
        try { 
            $params = $request->getParsedBody();

            $tokenId = $_SERVER['PHP_AUTH_PW'];
            $tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

            if ($tokenType == "TEST_") {
                $tokenId = substr($_SERVER['PHP_AUTH_PW'], 5);
            }

            $token = new TokenDAO();
            $responseToken = $token->getTokenId($tokenId);

            if ($responseToken) {
                $token_id = $responseToken['id'];
            }
            
            $v4uuid = UUID::v4();
            $data_url = file_get_contents("php://input");
            $data = json_decode($data_url); 
            
            $name = isset($data->name) ? $data->name : null;
            $document = isset($data->document) ? $data->document : null;
            $tax_regime = isset($data->tax_regime) ? $data->tax_regime : null;

            foreach ($data->partners as $dados){
                $partnerName = isset($dados->name) ? $dados->name : null;
                $partnerDocument = isset($dados->document) ? $dados->document : null;

                if (!$partnerName) {
                    throw new ApiException("Name of partner business is required");
                }
                if (!$partnerDocument) {
                    throw new ApiException("Partner's document is required");
                }
            }

            if (!$name) {
                throw new ApiException("Name is required");
            }

            if (!$document) {
                throw new ApiException("Document (CNPJ) is required");
            }

            if (!$tax_regime) {
                throw new ApiException("Tax regime is required");
            }

            $taxRegimeDao = new TaxRegimeDAO();
            $taxRegime = $taxRegimeDao->getTaxRegime($tax_regime);
            
            if (empty($taxRegime)) {
                throw new ApiException("Tax regime is not valid");
            }

            // Importação Empresa
            $path = "files/questor/empresa";
            $companyLayoutFile = $path . "/" . "cabecalho-empresa-ngem.nli";

            $fp = fopen($companyLayoutFile, "r");
            $companyContent = fread($fp, filesize($companyLayoutFile));
            fclose($fp);
            $base64CompanyFile = base64_encode($companyContent);

            $companyFile = fopen("dados-empresa.txt", "a+", 0);
            
            $company = (new CompanyModel())->setName($data->name)
                        ->setUid($v4uuid)
                        ->setDocument($data->document)
                        ->setTaxRegime($taxRegime["id"]);
            
            $tenantId = (new CompanyDao())->insertCompanies($company, $token_id);

            $companyLine = "";
            $companyLine .= ";" . $tenantId . ";" . $data->name . ";;\r\n";
            fwrite($companyFile, utf8_encode($companyLine), strlen(utf8_encode($companyLine)));
            
            fclose($companyFile);
            $base64Data = base64_encode($companyLine);
            
            // Cabeçalho Sócios Empresa
            $pathEmpresaSocio = "files/questor/socio-empresa";
            $partnerLayoutFile = $pathEmpresaSocio . "/" . "socio-ngem.nli";

            $fpPartner = fopen($partnerLayoutFile, "r");
            $partnerContent = fread($fpPartner, filesize($partnerLayoutFile));
            fclose($fpPartner);
            $base64PartnerFile = base64_encode($partnerContent);

            $partnerFile = fopen("dados-socio-empresa.txt", "a+", 0);

            $initialDate = date('d/m/Y');
            $typeSubscription = 1;
            $cep = "00000-000";
            $streetTypeCode = 33; // Rua
            $codigoMunicipio = 94;

            $dddPhone = "47";
            $phoneSemDDD = "999999999";
            $socioResponsavelLegal = 1;
            $socioEhAdm = 1;
            $valorNominalQuotas = 1;
            $declaraFisicaEscrit = 0;
            $declaraFisicaEscrit = 0;
            $qualificacaoSocio = 2;
            $socioOstensivo = 0;

            $dataInicioSocioEmpresa = date('d/m/Y');
            $dataFimSocioEmpresa = date('d/m/Y');

            // Sócios da empresa
            foreach ($data->partners as $dados){
                $v4uuidParner = UUID::v4();  
                
                $partnerLine .= ";" . $tenantId . ";" 
                                    . ";"             
                                    . $initialDate . ";"
                                    . $dados->name . ";"
                                    . $typeSubscription . ";"
                                    . $dados->document . ";" 
                                    . $dados->zip_code . ";"
                                    . $streetTypeCode . ";"
                                    . $dados->street . ";"
                                    . $dados->number . ";"
                                    . $dados->complement . ";"
                                    . $dados->neighborhood . ";" 
                                    . $dados->state . ";" 
                                    . $codigoMunicipio . ";" 
                                    . $dddPhone . ";" 
                                    . $phoneSemDDD . ";" 
                                    . ";"  
                                    . ";"  
                                    . ";"  
                                    . ";"  
                                    . ";"  
                                    . ";"  
                                    . $socioResponsavelLegal . ";" 
                                    . $socioEhAdm . ";" 
                                    . ";"  
                                    . $dados->job_description . ";"
                                    . ";"
                                    . $valorNominalQuotas . ";" 
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . $declaraFisicaEscrit . ";" 
                                    . $qualificacaoSocio . ";" 
                                    . $socioOstensivo . ";" 
                                    . $dataInicioSocioEmpresa . ";" 
                                    . $dataFimSocioEmpresa . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";"
                                    . ";" .
                ";\r\n"; 
                
                $partner = (new PartnerModel())->setDocument($dados->document)
                            ->setUid($v4uuidParner)                    
                            ->setName($dados->name)
                            ->setTenantId($tenantId);   
                $partnerDao = (new PartnerDao())->insertPartners($partner); 
            }

            fwrite($partnerFile, $partnerLine, strlen($partnerLine));
            fclose($partnerFile);
            $base64DataParner = base64_encode($partnerLine);

            // Estabelecimento
            $companyLayout[] = array(
                "nome" => "Empresa.nli",
                "arquivo" => $base64CompanyFile
            );

            $companyArray = [
                "leiautes"  => $companyLayout,
                "filtro" => "",
                "dados" => $base64Data,
                "podealterardados" => false,
                "executarvalidacaofinal" => false
            ];
            
            $jsonQuestor = json_encode($companyArray);
            
            // Partner array
            $partnerLayout[] = array(
                "nome" => "Socio.nli",
                "arquivo" => $base64PartnerFile
            );

            $partnerArray = [
                "leiautes"  => $partnerLayout,
                "filtro" => "",
                "dados" => $base64DataParner,
                "podealterardados" => false,
                "executarvalidacaofinal" => false
            ];

            $jsonPartnerQuestor = json_encode($partnerArray);
            
            // echo $jsonPartnerQuestor;
            // echo $jsonQuestor;
            
            // Curl Empresa
            $curl = curl_init("http://cazraps01.brazilsouth.cloudapp.azure.com:8080/integracao/importar"); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonQuestor);
            $curl_response = curl_exec($curl);

            if (curl_errno($ch)) {
                echo 'Request Error:' . curl_error($curl);
            }
           
            //echo $curl_response;
            curl_close($curl);

            // Curl Sócio       
            $curl = curl_init("http://cazraps01.brazilsouth.cloudapp.azure.com:8080/integracao/importar"); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonPartnerQuestor);
            $curl_response = curl_exec($curl);
            
            echo $curl_response;

            // ler json e pegar código do sócio no questor
            // $obj = json_decode($curl_response);
            
            // foreach ($obj->linhas as $dadosRetorno) {
                // echo 'chave: ' . $dadosRetorno->chave;
            // }

            if (curl_errno($ch)) {
                echo 'Request Error:' . curl_error($curl);
            }
            
            return $response->withJson([
                'id' => $v4uuid,
                'name' => $company->getName(),
                'document' => $company->getDocument(),
                'tax_regime' => strtoupper($taxRegime["name"])
            ], 201); 

            // Enviar dados Questor
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
    */

    public function limita_caracteres($texto, $limite, $quebra = true){
        $tamanho = strlen($texto);
        if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
           $novo_texto = $texto;
        }else{ // Se o tamanho do texto for maior que o limite
           if($quebra == true){ // Verifica a opção de quebrar o texto
              $novo_texto = trim(substr($texto, 0, $limite))."...";
           }else{ // Se não, corta $texto na última palavra antes do limite
              $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
              $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
           }
        }
        return $novo_texto; // Retorna o valor formatado
    }

    public function getCompanies(Request $request, Response $response, array $args): Response
    {        
        $page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;
        $limit = isset($_GET['size']) ? $_GET['size'] : 100;
        $offset = (--$page) * $limit;

        $tokenId = $_SERVER['PHP_AUTH_PW'];
        $tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

        if ($tokenType == "TEST_") {
            $tokenId = substr($_SERVER['PHP_AUTH_PW'], 5);
        }

        $token = new TokenDAO();
        $responseToken = $token->getTokenId($tokenId);

        if ($responseToken) {
            $token_id = $responseToken['id'];
        }
                
        $companiesDao = new CompanyDAO();
        $companies = $companiesDao->getAllCompanies($token_id, $limit, $offset);
        $array = array();

        foreach ($companies as $line):
            $array[] = array(
                    "id"  => $line['uid'],
                    "name" => $line['name'],
                    "document" => $line['cnpj'],
                    "tax_regime" => $line['taxRegimeName']
             ); 
        endforeach;

        $response = $response->withJson($array, 200);   
        return $response;
    }

    public function getCompaniesId(Request $request, Response $response, array $args): Response
    {        
        $uid = $args['id'];
        $companiesDao = new CompanyDAO();
        $companies = $companiesDao->getCompaniesId($uid);
        
        if (!$companies) {
            $response = $response->withJson([
                'errors' => array(
                    "message" => "Company not found"
                )
            ], 422);

            return $response;
            die;
        }
        
        $array = array();

        foreach ($companies as $line):
            $array = array(
                "id"  => $line['uid'],
                "name" => $line['name'],
                "document" => $line['cnpj'],
                "tax_regime" => $line['taxRegime']
             );  
        endforeach;
        
        $response = $response->withJson($array, 200);   

        return $response;
    }

    public function getPartnersCompanies(Request $request, Response $response, array $args): Response
    {        
        $uid = $args['id'];
        $companiesDao = new CompanyDAO();
        
        $companies = $companiesDao->getCompaniesId($uid);
        
        if (!$companies) {
            $response = $response->withJson([
                'errors' => array(
                    "message" => "Company not found"
                )
            ], 422);

            return $response;
            die;
        }
        
        $partners = $companiesDao->getPartnersCompanies($uid);
        $array = array();

        foreach ($partners as $line):
            
            $name = isset($line['name']) ? $line['name'] : null;
            $document = isset($line['document']) ? $line['document'] : null;

            $array[] = array(
                "name" => $name,
                "document" => $document
             );  
        endforeach;
        
        $response = $response->withJson($array, 200);   
        return $response;
    }

    public function deleteCompanies(Request $request, Response $response, array $args): Response
    {     
        $companyDao = new CompanyDAO();
        $company = $companyDao->getCompaniesId($args['id']);
        
        if ($company) {
            
            $companyDao->deleteCompany($args['id']);
            
            $response = $response->withJson([
                'deleted' => "true",
                'id' => $args['id']
            ], 200);            
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