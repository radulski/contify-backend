<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\CategoryModel;

class CategoryDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCategories($company, $limit, $offset): array
    {
        $statement = $this->pdo
        ->prepare('SELECT
                *
            FROM category
            WHERE
                tenantId = :tenantId
            AND
                enable = :enable
            LIMIT :limit 
            OFFSET :offset
        ;');
    
        $statement->bindParam(':tenantId', $company, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT); 
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT); 
        $statement->execute();
        $categories = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $categories;
    }

    public function getCategoriesId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM category
                WHERE
                    uid = :uid
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC); //estava feachAll
        
        return $customers;
    }

    public function insertCategory(CategoryModel $customer): void
    {
        $enable=1;
        
        $statement = $this->pdo->prepare('INSERT INTO category(
            createdAt, 
            enable,
            tenantId,
            updatedAt,
            name,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :updatedAt,
                :name,
                :uid
            );');

        $statement->execute([
            'createdAt' => $customer->getCreatedAt(),
            'enable' => $enable,
            'tenantId' => $customer->getTenantId(),
            'updatedAt' => $customer->getUpdatedAt(),
            'name' => $customer->getName(),
            'uid' => $customer->getUid()
        ]);
    }

    public function updateCategory(CategoryModel $category): void
    {
        $sql = 'update category set name = :name, updatedAt = :updatedAt where uid = :uid';
        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(":name", $category->getName());
        $statement->bindValue(":updatedAt", $category->getUpdatedAt());
        $statement->bindValue(":uid", $category->getUid());
        $statement->execute();
    }

    public function deleteCategory(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE category 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getCategoriesUid(string $id)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM category
                WHERE
                    id = :id
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC); //estava feachAll
        
        return $customers;
    }

    public function getCategoriesId2(string $id)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM category
                WHERE
                    id = :id
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC); //estava feachAll
        
        return $customers;
    }
}