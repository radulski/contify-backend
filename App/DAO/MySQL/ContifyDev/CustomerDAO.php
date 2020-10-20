<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\CustomerModel;

class CustomerDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCustomers($company, $limit, $offset): array
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM contact
                WHERE
                    tenantId = :tenantId
                AND
                    enable = :enable LIMIT :limit OFFSET :offset
            ;');
        
        $statement->bindParam(':tenantId', $company, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT); 
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT); 
        $statement->execute();
        $customers = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $customers;    
    }

    public function getCustomersId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM contact
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

    public function insertCustomer(CustomerModel $customer): void
    {
        $enable=1;
        
        $statement = $this->pdo->prepare('INSERT INTO contact(
            createdAt, 
            enable,
            tenantId,
            name,
            updatedAt,
            email,
            phone,
            pfpj,
            cpfCnpj,
            stateRegistration,
            birth,
            note,
            cep,
            address,
            number,
            complement,
            district,
            city,
            state,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :name,
                :updatedAt,
                :email,
                :phone,
                :pfpj,
                :cpfCnpj,
                :stateRegistration,
                :birth,
                :note,
                :cep,
                :address,
                :number,
                :complement,
                :district,
                :city,
                :state,
                :uid
            );');

        $statement->execute([
            'createdAt' => $customer->getCreatedAt(),
            'enable' => $enable,
            'tenantId' => $customer->getTenantId(),
            'name' => $customer->getName(),
            'updatedAt' => $customer->getUpdatedAt(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone(),
            'pfpj' => $customer->getPersonType(),
            'cpfCnpj' => $customer->getDocument(),
            'stateRegistration' => $customer->getStateRegistrationNumber(),
            'birth' => $customer->getDateOfBirth(),
            'note' => $customer->getNotes(),
            'cep' => $customer->getZipCode(),
            'address' => $customer->getStreet(),
            'number' => $customer->getNumber(),
            'complement' => $customer->getComplement(),
            'district' => $customer->getNeighborhood(),
            'city' => $customer->getCity(),
            'state' => $customer->getState(),
            'uid' => $customer->getUid()
        ]);
    }

    public function updateCustomer(CustomerModel $customer): void
    {
        $sql = 'update contact set name = :name';
        
        if ($customer->getEmail() <> null || '' === $customer->getEmail()) {
            $sql = $sql . ', email = :email';
        }

        if ($customer->getPhone() <> null || '' === $customer->getPhone()) {
            $sql = $sql . ', phone = :phone';
        }

        if ($customer->getPersonType() <> null || '' === $customer->getPersonType()) {
            $sql = $sql . ', pfpj = :person_type';
        }

        if ($customer->getDocument() <> null || '' === $customer->getDocument()) {
            $sql = $sql . ', cpfCnpj = :document';
        }

        if ($customer->getStateRegistrationNumber() <> null || '' === $customer->getStateRegistrationNumber()) {
            $sql = $sql . ', stateRegistration = :state_registration_number';
        }

        if ($customer->getDateOfBirth() <> null || '' === $customer->getDateOfBirth()) {
            $sql = $sql . ', birth = :date_of_birth';
        }

        if ($customer->getNotes() <> null || '' === $customer->getNotes()) {
            $sql = $sql . ', note = :notes';
        }

        if ($customer->getZipCode() <> null || '' === $customer->getZipCode()) {
            $sql = $sql . ', cep = :zip_code';
        }

        if ($customer->getStreet() <> null || '' === $customer->getStreet()) {
            $sql = $sql . ', address = :street';
        }

        if ($customer->getNumber() <> null || '' === $customer->getNumber()) {
            $sql = $sql . ', number = :number';
        }

        if ($customer->getComplement() <> null || '' === $customer->getComplement()) {
            $sql = $sql . ', complement = :complement';
        }

        if ($customer->getNeighborhood() <> null || '' === $customer->getNeighborhood()) {
            $sql = $sql . ', district = :neighborhood';
        }

        if ($customer->getCity() <> null || '' === $customer->getCity()) {
            $sql = $sql . ', city = :city';
        }

        if ($customer->getState() <> null || '' === $customer->getState()) {
            $sql = $sql . ', state = :state';
        }

        $where = ' where uid = :uid';   
        $statement = $this->pdo->prepare($sql . $where);

        $statement->bindValue(":name", $customer->getName());
        
        if ($customer->getEmail() <> null || '' === $customer->getEmail()) {
            $statement->bindValue(":email", $customer->getEmail());
        }

        if ($customer->getPhone() <> null || '' === $customer->getPhone()) {
            $statement->bindValue(":phone", $customer->getPhone());
        }

        if ($customer->getPersonType() <> null || '' === $customer->getPersonType()) {
            $statement->bindValue(":person_type", $customer->getPersonType());
        }

        if ($customer->getDocument() <> null || '' === $customer->getDocument()) {
            $statement->bindValue(":document", $customer->getDocument());
        }

        if ($customer->getStateRegistrationNumber() <> null || '' === $customer->getStateRegistrationNumber()) {
            $statement->bindValue(":state_registration_number", $customer->getStateRegistrationNumber());
        }

        if ($customer->getDateOfBirth() <> null || '' === $customer->getDateOfBirth()) {
            $statement->bindValue(":date_of_birth", $customer->getDateOfBirth());
        }

        if ($customer->getNotes() <> null || '' === $customer->getNotes()) {
            $statement->bindValue(":notes", $customer->getNotes());
        }

        if ($customer->getZipCode() <> null || '' === $customer->getZipCode()) {
            $statement->bindValue(":zip_code", $customer->getZipCode());
        }

        if ($customer->getStreet() <> null || '' === $customer->getStreet()) {
            $statement->bindValue(":street", $customer->getStreet());
        }

        if ($customer->getNumber() <> null || '' === $customer->getNumber()) {
            $statement->bindValue(":number", $customer->getNumber());
        }

        if ($customer->getComplement() <> null || '' === $customer->getComplement()) {
            $statement->bindValue(":complement", $customer->getComplement());
        }

        if ($customer->getNeighborhood() <> null || '' === $customer->getNeighborhood()) {
            $statement->bindValue(":neighborhood", $customer->getNeighborhood());
        }

        if ($customer->getCity() <> null || '' === $customer->getCity()) {
            $statement->bindValue(":city", $customer->getCity());
        }

        if ($customer->getState() <> null || '' === $customer->getState()) {
            $statement->bindValue(":state", $customer->getState());
        }

        $statement->bindValue(":uid", $customer->getUid());
        $statement->execute();
    }

    public function deleteCustomer(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE contact 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }
}