<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\UserTokenModel;

class UserTokenDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function deleteToken()
    {
        $statement = $this->pdo
            ->prepare('DELETE FROM userToken');

        $statement->execute();
    }

    public function generateToken(UserTokenModel $userToken) {
        $statement = $this->pdo->prepare('INSERT INTO userToken(token) VALUES(
                :token
            );');

        $statement->execute([
            'token' => $userToken->getToken()
        ]);
    }
}