<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\TokenModel;

class TokenDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTokenId(string $token): array
    {
        $enable = 1;
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM token
                WHERE
                    token = :token
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':token', $token, \PDO::PARAM_STR);
        $statement->bindParam(':enable', $enable);
        $statement->execute();
        $token = $statement->fetch(\PDO::FETCH_ASSOC); //estava feachAll

        return $token;
    }
}