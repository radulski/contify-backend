<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\CompanyModel;
use App\Models\PartnerModel;

class CompanyDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCompanies($token_id, $limit, $offset): array
    {
        $enable = 1;
        
        /*
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM tenant
                WHERE
                    token_id = :token_id
                AND
                    enable = :enable 
                LIMIT :limit OFFSET :offset
            ;');
        */

        $statement = $this->pdo
        ->prepare('SELECT 
                    t.id, t.name, t.cnpj, t.uid, tr.name as taxRegimeName 
                FROM tenant t
                
                LEFT JOIN  taxRegime tr
                ON tr.id = t.taxRegimeId
                
                WHERE
                    t.token_id = :token_id
                AND
                    enable = :enable
                order by id
                LIMIT :limit OFFSET :offset
        ;');
        
        
        
        
        $statement->bindParam(':token_id', $token_id, \PDO::PARAM_STR);
        $statement->bindParam(':enable', $enable);
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT); 
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT); 
        $statement->execute();
        $companies = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $companies;
    }

    public function getCompaniesId(string $uid)
    {
        $enable = 1;
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM tenant
                WHERE
                    uid = :uid
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindParam(':enable', $enable);
        $statement->execute();
        $companies = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $companies;
    }

    public function getCompaniesIdU(string $uid)
    {
        $enable = 1; 
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM tenant
                WHERE
                    uid = :uid
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindParam(':enable', $enable);
        $statement->execute();
        $companies = $statement->fetch(\PDO::FETCH_ASSOC);

        return $companies;
    }

    public function insertCompanies(CompanyModel $company, $token_id): int
    {
        $createdAt = date('Y-m-d H:i:s');
        $statement = $this->pdo->prepare('INSERT INTO tenant(
            createdAt, 
            enable,
            name,
            cnpj,
            taxRegimeId,
            token_id,
            integrationId,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :name,
                :cnpj,
                :taxRegimeId,
                :token_id,
                :integrationId,
                :uid
            );');

        $statement->bindParam(':createdAt', $createdAt, \PDO::PARAM_STR);
        $statement->bindValue(":enable", true, \PDO::PARAM_BOOL);
        $statement->bindParam(':name', $company->getName());
        $statement->bindParam(':cnpj', $company->getDocument(), \PDO::PARAM_STR);
        $statement->bindParam(':taxRegimeId', $company->getTaxRegime(), \PDO::PARAM_INT);
        $statement->bindParam(':token_id', $token_id);
        $statement->bindValue(":integrationId", $company->getIntegrationId(), \PDO::PARAM_INT);
        $statement->bindParam(':uid', $company->getUid(), \PDO::PARAM_STR);
        $statement->execute();
                    
        $id = $this->pdo->lastInsertId();
        return $id; 
    }

    public function getPartnersCompanies($uid): array
    {
        $statement = $this->pdo
            ->prepare('SELECT
                        t.id,
                        t.uid,
                        p.name,
                        p.document
                    FROM tenant t
                    INNER JOIN partner p
                    ON p.tenantId = t.id
                    WHERE t.uid = :uid
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->execute();
        $partners = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $partners;
    }

    public function getTokenCompany(): array
    {
        $token_id = 5;
        $token = $this->pdo
        ->query('SELECT * FROM tenant where token_id = ' . $token_id . '')
        ->fetchAll(\PDO::FETCH_ASSOC);
    
        return $token;
    }

    public function deleteCompany(string $uid)
    {
        $updatedAt = date('Y-m-d H:i:s');
        
        $statement = $this->pdo
            ->prepare('UPDATE tenant 
                    SET enable = :enable,
                    updatedAt = :updatedAt
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->bindParam(':updatedAt', $updatedAt);
        $statement->execute();
    }

    public function getAllCompaniesIntegrated(): array {
        $enable = 1;
        
        $statement = $this->pdo
            ->prepare('SELECT 
                        t.id, t.name, t.integrationId
                    FROM tenant t
                    WHERE
                        enable = :enable
                    order by id
        ;');
        
        $statement->bindParam(':enable', $enable);
        $statement->execute();
        $companies = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $companies;
    }   
}