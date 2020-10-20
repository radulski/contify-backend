<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\FinancialMovementModel;

class FinancialMovementDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllFinancialMovements(): array
    {
        $financialMovements = $this->pdo
        ->query('SELECT * FROM launch')
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
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetch(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function insertFinancialMovement(FinancialMovementModel $financialMovement): int
    {        
        $value=0/
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
                :uid
            );');

        $statement->execute([
            'createdAt'      => $financialMovement->getCreatedAt(),
            'enable'         => $financialMovement->getEnable(),
            'tenantId'       => $financialMovement->getTenantId(),
            'updatedAt'      => $financialMovement->getUpdatedAt(),
            'contact_id'     => $financialMovement->getContactId(),
            'date'           => $financialMovement->getDate(),
            'value'          => $value,
            'bankAccountId'  => $financialMovement->getBankAccountId(),
            'description'    => $financialMovement->getNotes(),
            'type'           => $financialMovement->getMovementType(),
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
}