<?php
namespace App\DAO\MySQL\ContifyDev;
use App\Models\IntegrationModel;

class IntegrationDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertIntegration(IntegrationModel $integration): int
    {
        $statement = $this->pdo->prepare('INSERT INTO integration(
            integrated, 
            integratedAt,
            tableName) 
            VALUES(
                :integrated,
                :integratedAt,
                :tableName
            );');

        $statement->bindValue(":integrated", false, \PDO::PARAM_BOOL);
        $statement->bindParam(':integratedAt', $integration->getIntegratedAt(), \PDO::PARAM_STR);
        $statement->bindParam(':tableName', $integration->getTableName(), \PDO::PARAM_STR);
        $statement->execute();
                    
        return $this->pdo->lastInsertId();
    }

    public function updateCompaniesIntegrated(int $id) {        
        $tableName = "tenant";
        
        $statement = $this->pdo
            ->prepare("UPDATE integration 
                    SET integrated = :integrated
                    WHERE id = :id
                    AND tableName = :tableName");

        $statement->bindParam(":id", $id);
        $statement->bindParam(":tableName", $tableName, \PDO::PARAM_STR);
        $statement->bindValue(":integrated", true, \PDO::PARAM_BOOL);
        $statement->execute();
    }
}