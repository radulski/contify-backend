<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\MySQL\ContifyDev\AttachmentDAO;
use App\DAO\MySQL\ContifyDev\CompanyDAO;
use App\Models\AttachmentModel;
use App\Traits\UUID;
use App\Exceptions\ApiException;
use thiagoalessio\TesseractOCR\TesseractOCR;

final class AttachmentController
{
    public function insertAttachment(Request $request, Response $response, array $args): Response
    {	
    	try {	
	        
	        $companyDao = new CompanyDAO();
	        $company = $companyDao->getCompaniesIdU($args['company_id']);

	        if (!$company) {
	            throw new ApiException("Company not found");
	        } 

	        $tenantId = $company['id'];
			
	    	$files = $request->getUploadedFiles();
	        $newfile = $files['arquivo'];
	        $fileName = $newfile->getClientFilename();
	        $fileSize = $newfile->getSize();
	        $fileType = $newfile->getClientMediaType();

	        $attachmentDao = new AttachmentDAO();
	        $attachment = new AttachmentModel();
            $v4uuid = UUID::v4();

			$attachment->setCreatedAt(date('Y-m-d H:i:s'))
					->setEnable(true)
					->setTenantId($tenantId)
					->setFileSize($fileSize)
					->setFileName($fileName)
					->setFileType($fileType)
					->setUid($v4uuid);

			$attachmentDao->insertAttachment($attachment);
			
	        return $response->withJson([
                'id' => $v4uuid,
                'created_at' => $attachment->getCreatedAt()
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
}