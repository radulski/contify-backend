<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\ServiceInvoiceModel;

class ServiceInvoiceDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertServiceInvoice(ServiceInvoiceModel $serviceInvoice, $dados, $type, $nome, $tamanho, $fp): void
    {
        $createdAt = date('Y-m-d H:i:s');
        $tenantId = 3;

        $sql = "INSERT INTO invoice(createdAt, tenantId, type, content, fileName, fileSize, batchInvoiceId) 
        VALUES (:createdAt, :tenantId, :type, :content, :fileName, :fileSize, :batchInvoiceId)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':createdAt', $createdAt);
        $stmt->bindParam(':tenantId', $serviceInvoice->getTenantId());
        $stmt->bindParam(':batchInvoiceId', $serviceInvoice->getBatchInvoiceId());
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $dados, \PDO::PARAM_LOB);
        $stmt->bindParam(':fileName', $nome);
        $stmt->bindParam(':fileSize', $tamanho);
        $stmt->execute();
    }

    public function insertServiceInvoiceBatch(ServiceInvoiceModel $serviceInvoice): void
    {
        $createdAt = date('Y-m-d H:i:s');
        $tenantId = 3;
        $enable = 1;

        $statement = $this->pdo->prepare('INSERT INTO batchInvoice(
            createdAt,
            enable,
            tenantId,
            yearPurchase,
            monthPurchase,
            uid)
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :yearPurchase,
                :monthPurchase,
                :uid
            );');

        $statement->execute([
            'createdAt' => $createdAt,
            'enable' => $enable,
            'tenantId' => $tenantId,
            'yearPurchase' => $serviceInvoice->getNumber(),
            'monthPurchase' => $serviceInvoice->getTotalValue()
        ]);
    }

    public function getAllBatchInvoices($company): array
    {
        $enable = 1;
        $batch = $this->pdo
        ->query('SELECT * FROM batchInvoice where tenantId = ' . $company . ' and enable = ' . $enable)
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $batch;
    }

    public function getBatchId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM batchInvoice
                WHERE
                    uid = :uid
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC); //estava feachAll
        
        return $customers;
    }

    public function deleteBatch(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE batchInvoice 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

}