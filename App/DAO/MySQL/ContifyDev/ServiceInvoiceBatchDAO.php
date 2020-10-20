<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\ServiceInvoiceBatchModel;

class ServiceInvoiceBatchDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertServiceInvoiceBatch(ServiceInvoiceBatchModel $serviceInvoiceBatch): int
    {
        $createdAt = date('Y-m-d H:i:s');
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

        try { 
            //$this->pdo->beginTransaction(); 

            $statement->execute([
                'createdAt' => $createdAt,
                'enable' => $enable,
                'tenantId' => $serviceInvoiceBatch->getTenantId(),
                'yearPurchase' => $serviceInvoiceBatch->getYearPurchase(),
                'monthPurchase' => $serviceInvoiceBatch->getMonthPurchase(),
                'uid' => $serviceInvoiceBatch->getUid()
            ]);

            //$this->pdo->commit();
            $serviceId = $this->pdo->lastInsertId();

        } catch(PDOExecption $e) { 
            //$this->pdo->rollback(); 
            print "Error!: " . $e->getMessage() . "</br>"; 
        } 

        return $serviceId;
    }
}