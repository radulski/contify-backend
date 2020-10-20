<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\TransferModel;

class TransferDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTransfers($company): array
    {
        $enable = 1;
        $customers = $this->pdo
        ->query('select t.uid, t.originBankAccountId, t.destinationBankAccountId, l.value
        from transferBankAccount t
        inner join launch l
        on l.transferId = t.id
        where t.tenantId = ' . $company . 
        ' and t.enable = ' . $enable . 
        ' group by t.id' )
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $customers;
    }

    public function getTransfersId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('select t.uid, t.originBankAccountId, t.destinationBankAccountId, l.value
            from transferBankAccount t
            inner join launch l
            on l.transferId = t.id
                WHERE
                    t.uid = :uid
                AND
                    t.enable = :enable
                GROUP BY t.id
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC);
        
        return $customers;
    }

    public function insertTransfer(TransferModel $customer): int
    {
        $enable=1;
        
        $statement = $this->pdo->prepare('INSERT INTO transferBankAccount(
            createdAt, 
            enable,
            tenantId,
            name,
            originBankAccountId,
            destinationBankAccountId,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :name,
                :originBankAccountId,
                :destinationBankAccountId,
                :uid
            );');

        $statement->execute([
            'createdAt' => $customer->getCreatedAt(),
            'enable' => $enable,
            'tenantId' => $customer->getTenantId(),
            'name' => $customer->getName(),
            'originBankAccountId' => $customer->getOriginBankAccountId(),
            'destinationBankAccountId' => $customer->getDestinationBankAccountId(),
            'uid' => $customer->getUid()
        ]);

        $id = $this->pdo->lastInsertId();
        return $id;
    }

    public function deleteTransfer(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE transfer 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function insertTransferBankAccount(TransferModel $customer): int
    {
        $enable=1;
        
        $statement = $this->pdo->prepare('INSERT INTO transferBankAccount(
            createdAt, 
            enable,
            tenantId,
            bankAccountId,
            typeTransferBankAccountId,
            value,
            batchTransferId,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :bankAccountId,
                :typeTransferBankAccountId,
                :value,
                :batchTransferId,
                :uid
            );');

        $statement->execute([
            'createdAt' => $customer->getCreatedAt(),
            'enable' => $enable,
            'tenantId' => $customer->getTenantId(),
            'bankAccountId' => $customer->getBankAccountId(),
            'typeTransferBankAccountId' => $customer->getTypeTransferBankAccountId(),
            'value' => $customer->getValue(),
            'batchTransferId' => $customer->getBatchTransferId(),
            'uid' => $customer->getUid()
        ]);

        $id = $this->pdo->lastInsertId();
        return $id;
    }


}