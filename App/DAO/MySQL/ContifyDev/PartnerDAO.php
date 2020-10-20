<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\PartnerModel;

class PartnerDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertPartners(PartnerModel $partner)
    {
        $createdAt = date('Y-m-d H:i:s');
        $statement = $this->pdo->prepare('INSERT INTO partner(
            createdAt, 
            enable,
            tenantId,
            name,
            document,
            jobDescription,
            zipCode,
            street,
            number,
            complement,
            neighborhood,
            city,
            state,
            phone,
            integrationId,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :name,
                :document,
                :jobDescription,
                :zipcode,
                :street,
                :number,
                :complement,
                :neighborhood,
                :city,
                :state,
                :phone,
                :integrationId,
                :uid
            );');

        $statement->bindParam(':createdAt', $createdAt, \PDO::PARAM_STR);
        $statement->bindValue(":enable", true, \PDO::PARAM_BOOL);
        $statement->bindParam(':tenantId', $partner->getTenantId(), \PDO::PARAM_INT);
        $statement->bindParam(':name', $partner->getName(), \PDO::PARAM_STR);
        $statement->bindParam(':document', $partner->getDocument(), \PDO::PARAM_STR);
        $statement->bindParam(':jobDescription', $partner->getJobDescription(), \PDO::PARAM_STR);
        $statement->bindParam(':zipcode', $partner->getZipCode(), \PDO::PARAM_STR);
        $statement->bindParam(':street', $partner->getStreet(), \PDO::PARAM_STR);
        $statement->bindParam(':number', $partner->getNumber(), \PDO::PARAM_STR);
        $statement->bindParam(':complement', $partner->getComplement(), \PDO::PARAM_STR);
        $statement->bindParam(':neighborhood', $partner->getNeighborhood(), \PDO::PARAM_STR);
        $statement->bindParam(':city', $partner->getCity(), \PDO::PARAM_STR);
        $statement->bindParam(':state', $partner->getState(), \PDO::PARAM_STR);
        $statement->bindParam(':phone', $partner->getPhone(), \PDO::PARAM_STR);
        $statement->bindParam(':integrationId', $partner->getIntegrationId(), \PDO::PARAM_INT);
        $statement->bindParam(':uid', $partner->getUid(), \PDO::PARAM_STR);
        $statement->execute();
    }

    public function getAllPartnersIntegrated(): array {
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