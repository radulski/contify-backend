<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\DAO\MySQL\ContifyDev\IntegrationDAO;
use App\DAO\MySQL\ContifyDev\PartnerDAO;
use App\Models\CompanyModel;
use App\Exceptions\ApiException;

final class IntegrationController
{    
    // private $integrationService;
    
    /*
    public function __construct(IntegrationService $integrationService)
    {
        $this->integrationService = $integrationService;
    }
    */
    
    public function insertIntegrationCompanies(Request $request, Response $response, array $args): Response
    {
        try {
            // Integração dados Empresas
            $path = "files/questor/empresa";
            $companyLayoutFile = $path . "/" . "cabecalho-empresa-ngem.nli";

            $fp = fopen($companyLayoutFile, "r");
            $companyContent = fread($fp, filesize($companyLayoutFile));
            fclose($fp);
            $base64CompanyFile = base64_encode($companyContent);

            $companyFile = fopen("dados-empresa.txt", "a+", 0);
            
            // Empresas integradas
            $companyDao = new CompanyDAO();
            $result = $companyDao->getAllCompaniesIntegrated();
            
            // Criar arquivo
            $companyLine = "";
            
            foreach ($result as $line):
                $tenantId = $line["id"];
                $name = $line["name"]; 
                
                $companyLine .= ";" . $tenantId . ";" . $name . ";;\r\n";
                fwrite($companyFile, utf8_encode($companyLine), strlen(utf8_encode($companyLine)));
            endforeach;

            fclose($companyFile);
            $base64Data = base64_encode($companyLine);


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
            
            
            // Curl Empresa
            $curl = curl_init("http://cazraps01.brazilsouth.cloudapp.azure.com:8080/integracao/importar"); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonQuestor);
            $curl_response = curl_exec($curl);
            
            // echo $curl_response;

            if (curl_errno($curl)) {
                echo 'Request Error:' . curl_error($curl);
                // throw new ApiException("erro curl");
            } else {
                // Atualizar empresas integradas
                $integrationDao = new IntegrationDAO();

                foreach ($result as $line):
                    $integrationDao->updateCompaniesIntegrated($line["integrationId"]);
                    $idt = $line["integrationId"];
                endforeach;
            }
            
            // Colocar como atualizado se não ocorrer problemas com o nweb

            //echo $curl_response;
            curl_close($curl);
            
            





            /*
            // Sócios Empresa
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



            // Empresas integradas
            $partnerDao = new PartnerDAO();
            $result = $partnerDao->getAllPartnersIntegrated();

            $partnerLine = "";

            // Sócios da empresa
            foreach ($result as $line) {
                // $v4uuidParner = UUID::v4();  
                
                // $phone = $line

                $partnerLine .= ";" . $tenantId . ";" 
                                    . ";"             
                                    . $initialDate . ";"
                                    . $line["name"] . ";"
                                    . $typeSubscription . ";"
                                    . $line["document"] . ";" 
                                    . $line["zip_code"] . ";"
                                    . $streetTypeCode . ";"
                                    . $line["street"] . ";"
                                    . $dados["number"] . ";"
                                    . $dados["complement"] . ";"
                                    . $dados["neighborhood"] . ";" 
                                    . $dados["state"] . ";" 
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
            }

            fwrite($partnerFile, $partnerLine, strlen($partnerLine));
            fclose($partnerFile);
            $base64DataParner = base64_encode($partnerLine);

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

            // Curl Sócio       
            $curl = curl_init("http://cazraps01.brazilsouth.cloudapp.azure.com:8080/integracao/importar"); 
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonPartnerQuestor);
            $curl_response = curl_exec($curl);

            if (curl_errno($ch)) {
                echo 'Request Error:' . curl_error($curl);
            }
            */


            // Estabelecimento Empresa

            $response = $response->withJson([
                'situacao' => 'ei'
            ], 200);
            
            // $response = $curl_response;
    
            return $response;

        } catch(ApiException $ex) {
            return $response->withJson([
                'errors1' => array(
                    "message" => $ex->getMessage()
                )
            ], 422);   
        } catch(\Exception | \Throwable $ex) {
            return $response->withJson([
                'errors2' => array(
                    "message" => $ex->getMessage()
                )
            ], 500);
        }

        /*
        $response = $response->withJson([
            "situacao" => "ok"
        ], 200);

        return $response;
        */
        
    }
}