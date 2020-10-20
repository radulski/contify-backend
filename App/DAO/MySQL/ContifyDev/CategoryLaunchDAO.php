<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\CategoryLaunchModel;

class CategoryLaunchDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertCategoriesLaunch(CategoryLaunchModel $categoryLaunch): void
    {
        $enable = 1;
        $createdAt = date('Y-m-d H:m:s');

        $statement = $this->pdo->prepare('INSERT INTO categoryLaunch(
            createdAt,
            enable,
            tenantId,
            categoryId,
            launchId,
            value,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :categoryId,
                :launchId,
                :value,
                :uid
            );');

        $statement->execute([
            'createdAt' => $createdAt,
            'enable' => $enable,
            'tenantId' => $categoryLaunch->getTenantId(),
            'categoryId' => $categoryLaunch->getCategoryId(),
            'launchId' => $categoryLaunch->getLaunchId(),
            'value' => $categoryLaunch->getValue(),
            'uid' => $categoryLaunch->getUid()
        ]);
    }

    public function updateCategoriesLaunch(CategoryLaunchModel $categoryLaunch): void
    {
        $sql = 'update categoryLaunch set categoryId = :categoryId, value = :value where uid = :uid';
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(":categoryId", $categoryLaunch->getCategoryId());
        $statement->bindValue(":value", $categoryLaunch->getValue());
        $statement->bindValue(":uid", $categoryLaunch->getUid());
        $statement->execute();
    }

    public function getCategoriesLaunchId(string $launchId)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM categoryLaunch
                WHERE
                    launchId = :launchId
            ;');
        $statement->bindParam(':launchId', $launchId, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function deleteCategoriesLaunch(string $launchId)
    {
        $statement = $this->pdo
            ->prepare('UPDATE categoryLaunch 
                    SET enable = :enable 
                    WHERE launchId = :launchId');

        $statement->bindParam(':launchId', $launchId, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteCategoriesLaunchId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE categoryLaunch 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getCategoriesLaunchUid(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM categoryLaunch
                WHERE
                    uid = :uid
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function getCategoriesLaunchUid2(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM categoryLaunch
                WHERE
                    uid = :uid
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetch(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function getCategoriesLaunchUid3(string $uid, string $launchId)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM categoryLaunch
                WHERE
                    uid = :uid
                AND
                    launchId = :launchId
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindParam(':launchId', $launchId, \PDO::PARAM_STR);
        $statement->execute();
        $financialMovements = $statement->fetch(\PDO::FETCH_ASSOC);

        return $financialMovements;
    }

    public function deleteCategoriesLaunchUpdate(array $array, $idLaunchCat)
    {        
        $i=1;
        foreach($array as $dad) {
            $uid = $array[$i];   
            $i++;
        }

        $filter   = ["min_price" => $idLaunchCat];
        $editions = $array;

        $editions = array_combine(
            array_map(function($i) { 
                return ':id'.$i; 
            }, array_keys($editions)),
            $editions
        );

        $in_placeholders = implode(',', array_keys($editions));
        
        if ($in_placeholders == "") {
            $sql = "DELETE FROM categoryLaunch WHERE launchId = :min_price";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(array_merge($filter,$editions));
        } else {
            $sql = "DELETE FROM categoryLaunch WHERE launchId = :min_price AND uid NOT IN ($in_placeholders)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(array_merge($filter,$editions));
        }
    }    
}