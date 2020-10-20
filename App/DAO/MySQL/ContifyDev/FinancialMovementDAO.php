<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\FinancialMovementModel;

class FinancialMovementDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllFinancialMovements($company): array
    {
        $enable = 1;
        $financialMovements = $this->pdo
        ->query('SELECT * FROM launch where tenantId = ' . $company . ' and enable = ' . $enable . ' order by date')
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function getFinancialMovementsId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM launch
                WHERE
                    uid = :uid
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $financialMovements = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function insertFinancialMovement(FinancialMovementModel $financialMovement): int
    {        
        //$value=0;
        $statement = $this->pdo->prepare('INSERT INTO launch(
            createdAt, 
            enable,
            tenantId,
            updatedAt,
            contact_id,
            date,
            value,
            bankAccountId,
            description,
            type,
            transferId,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :updatedAt,
                :contact_id,
                :date,
                :value,
                :bankAccountId,
                :description,
                :type,
                :transferId,
                :uid
            );');

        $statement->execute([
            'createdAt'      => $financialMovement->getCreatedAt(),
            'enable'         => $financialMovement->getEnable(),
            'tenantId'       => $financialMovement->getTenantId(),
            'updatedAt'      => $financialMovement->getUpdatedAt(),
            'contact_id'     => $financialMovement->getContactId(),
            'date'           => $financialMovement->getDate(),
            'value'          => $financialMovement->getValue(),
            'bankAccountId'  => $financialMovement->getBankAccountId(),
            'description'    => $financialMovement->getNotes(),
            'type'           => $financialMovement->getMovementType(),
            'transferId'     => $financialMovement->getTransferId(),
            'uid'            => $financialMovement->getUid()
        ]);

        $id = $this->pdo->lastInsertId();
        return $id;
    }

    public function deleteFinancialMovement(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE launch 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getCategoryId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM category
                WHERE
                    uid = :uid
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetch(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function getFinancialMovementByTransferId(string $transferId)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM launch
                WHERE
                    transferId = :transferId
            ;');
        $statement->bindParam(':transferId', $transferId, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetch(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function deleteFinancialMovementByIdTransfer(string $trasnferId)
    {
        $statement = $this->pdo
            ->prepare('UPDATE launch 
                    SET enable = :enable, updatedAt = :updatedAt 
                    WHERE transferId = :transferId');

        $statement->bindParam(':transferId', $trasnferId, \PDO::PARAM_STR);
        $statement->bindParam(':updatedAt', date('Y-m-d H:i:s'));
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function updateFinancialMovement(FinancialMovementModel $financialMovement): void
    {
        $sql = 'update launch set';
        $virg = true;
        $tem_sql = false;

        if ($financialMovement->getContactId() <> null || '' === $financialMovement->getContactId()) {
            $sql = $sql . ' contact_id = :customer_id';
            $virg = false;
            $tem_sql = true;
        }

        if ($financialMovement->getBankAccountId() <> null || '' === $financialMovement->getBankAccountId()) {
            if (!$virg) {
                $sql = $sql . ', bankAccountId = :bank_account_id';
                $virg = true;
            } else {
                $sql = $sql . ' bankAccountId = :bank_account_id';
                $virg = false;
            }
            $tem_sql = true;
        }

        if ($financialMovement->getMovementType() <> null || '' === $financialMovement->getMovementType()) {
            if ($virg) {
                $sql = $sql . ', type = :movement_type';
                $virg = true;
            } else {
                $sql = $sql . ' type = :movement_type';
                $virg = false;
            }  
            $tem_sql = true;
        }

        if ($financialMovement->getDate() <> null || '' === $financialMovement->getDate()) {
            if ($virg) {
                $sql = $sql . ', date = :date';
                $virg = true;
            } else {
                $sql = $sql . ' date = :date';
                $virg = false;
            }   
            $tem_sql = true;
        }

        if ($financialMovement->getNotes() <> null || '' === $financialMovement->getNotes()) {
            if ($virg) {
                $sql = $sql . ', description = :description';
                $virg = true;
            } else {
                $sql = $sql . ' description = :description';
                $virg = false;
            }
            $tem_sql = true;
        }

        $where = ' where uid = :uid';   
        $statement = $this->pdo->prepare($sql . $where);

        if ($financialMovement->getContactId() <> null || '' === $financialMovement->getContactId()) {
            $statement->bindValue(":customer_id", $financialMovement->getContactId());
        }

        if ($financialMovement->getBankAccountId() <> null || '' === $financialMovement->getBankAccountId()) {
            $statement->bindValue(":bank_account_id", $financialMovement->getBankAccountId());
        }

        if ($financialMovement->getMovementType() <> null || '' === $financialMovement->getMovementType()) {
            $statement->bindValue(":movement_type", $financialMovement->getMovementType());
        }

        if ($financialMovement->getDate() <> null || '' === $financialMovement->getDate()) {
            $statement->bindValue(":date", $financialMovement->getDate());
        }

        if ($financialMovement->getNotes() <> null || '' === $financialMovement->getNotes()) {
            $statement->bindValue(":description", $financialMovement->getNotes());
        }

        if ($tem_sql) {
            $statement->bindValue(":uid", $financialMovement->getUid());
            $statement->execute();
        }
    }

    public function getCategoryUid(string $id)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM category
                WHERE
                    id = :id
            ;');
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetch(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function insertFinancialMovementCategories(FinancialMovementModel $financialMovement): int
    {        
        $statement = $this->pdo->prepare('INSERT INTO categoryLaunch(
            createdAt, 
            enable,
            tenantId,
            value,
            categoryId,
            launchId,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :value,
                :categoryId,
                :launchId,
                :uid
            );');

        $statement->execute([
            'createdAt'      => $financialMovement->getCreatedAt(),
            'enable'         => $financialMovement->getEnable(),
            'tenantId'       => $financialMovement->getTenantId(),
            'value'          => $financialMovement->getValue(),
            'categoryId'     => $financialMovement->getCategoryId(),
            'launchId'       => $financialMovement->getLaunchId(),
            'uid'            => $financialMovement->getUid()
        ]);

        $id = $this->pdo->lastInsertId();
        return $id;
    }
}