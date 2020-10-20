<?php

namespace App\DAO\MySQL\ContifyDev;

class TaxRegimeDAO extends Conexao {

    public function __construct() {
        parent::__construct();
    }

    public function getTaxRegime(string $taxRegime) {
        $enable = 1;
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM taxRegime
                WHERE
                    name = :taxRegime
            ;');
        $statement->bindParam(':taxRegime', $taxRegime, \PDO::PARAM_STR);
        $statement->execute();
        $taxRegime = $statement->fetch(\PDO::FETCH_ASSOC);

        return $taxRegime;
    }
}