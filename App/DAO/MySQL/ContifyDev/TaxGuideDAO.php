<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\TaxGuideModel;

class TaxGuideDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTaxGuide($company)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM taxGuide
                WHERE
                    tenantId = :tenantId
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':tenantId', $company, \PDO::PARAM_INT);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $taxGuide = $statement->fetch(\PDO::FETCH_ASSOC); //estava feachAll
        
        return $taxGuide;
    }
}