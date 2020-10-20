<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\AttachmentModel;

class AttachmentDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertAttachment(AttachmentModel $attachment): void
    {        
        $statement = $this->pdo->prepare('INSERT INTO attachment(
            createdAt, 
            enable,
            tenantId,
            fileName,
            fileSize,
            fileType,
            uid
          ) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :fileName,
                :fileSize,
                :fileType,
                :uid
            );');

        $statement->bindValue("createdAt", $attachment->getCreatedAt());
        $statement->bindValue("enable", 1, \PDO::PARAM_BOOL);
        $statement->bindValue("tenantId", $attachment->getTenantId());
        $statement->bindValue("fileName", $attachment->getFileName());
        $statement->bindValue("fileSize", $attachment->getFileSize());
        $statement->bindValue("fileType", $attachment->getFileType());
        $statement->bindValue("uid", $attachment->getUid());
        $statement->execute();
    }
}