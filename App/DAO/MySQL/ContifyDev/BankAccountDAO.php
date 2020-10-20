<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\BankAccountModel;

class BankAccountDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllBankAccounts($company): array
    {
        $enable = 1;
        $bankAccounts = $this->pdo
        ->query('SELECT * FROM bankAccount where tenantId = ' . $company . ' and enable = ' . $enable)
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $bankAccounts;
    }

    public function getBankAccountsId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM bankAccount
                WHERE
                    uid = :uid
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC);

        return $customers;
    }

    public function getBankAccountsUid(string $id)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM bankAccount
                WHERE
                id = :id
            ;');
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->execute();
        $customers = $statement->fetch(\PDO::FETCH_ASSOC);

        return $customers;
    }

    public function insertBankAccount(BankAccountModel $bankAccount): int
    {
        $statement = $this->pdo->prepare('INSERT INTO bankAccount(
            createdAt, 
            updatedAt,
            enable,
            tenantId,
            bankCode,
            bankName,
            agency,
            account,
            uid) 
            VALUES(
                :createdAt,
                :updatedAt,
                :enable,
                :tenantId,
                :bankCode,
                :bankName,
                :agency,
                :account,
                :uid
            );');

        $statement->execute([
            'createdAt' => $bankAccount->getCreatedAt(),
            'updatedAt' => $bankAccount->getUpdatedAt(),
            'enable' => $bankAccount->getEnable(),
            'tenantId' => $bankAccount->getTenantId(),
            'bankCode' => $bankAccount->getBankCode(),
            'bankName' => $bankAccount->getBankName(),
            'agency' => $bankAccount->getAgency(),
            'account' => $bankAccount->getAccount(),
            'uid' => $bankAccount->getUid()
        ]);

        $id = $this->pdo->lastInsertId();
        return $id;
    }

    public function updateBankAccount(BankAccountModel $bankAccount): void
    {
        $statement = $this->pdo->prepare('UPDATE bankAccount SET
                                        bankCode :bankCode,
                                        bankName = :bankName,
                                        phone = :phone,
                                        pfpj = :person_type,
                                        cpfCnpj = :document,
                                        stateRegistration = :state_registration_number,
                                        birth = :date_of_birth,
                                        note = :notes,
                                        cep = :zip_code,
                                        address = :street,
                                        number = :number,
                                        complement = :complement,
                                        district = :neighborhood,
                                        city = :city,
                                        state = :state
                                    WHERE
                                        uid = :uid');
        $statement->execute([
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone(),
            'person_type' => $customer->getPersonType(),
            'document' => $customer->getDocument(),
            'state_registration_number' => $customer->getStateRegistrationNumber(),
            'date_of_birth' => $customer->getDateOfBirth(),
            'notes' => $customer->getNotes(),
            'zip_code' => $customer->getZipCode(),
            'street' => $customer->getStreet(),
            'number' => $customer->getNumber(),
            'complement' => $customer->getComplement(),
            'neighborhood' => $customer->getNeighborhood(),
            'city' => $customer->getCity(),
            'state' => $customer->getState(),
            'uid' => $customer->getUid()
        ]);
    }

    public function deleteBankAccount(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE bankAccount 
                    SET enable = :enable,
                    updatedAt = :updatedAt
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->bindValue(":updatedAt", date('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $statement->execute();
    }
}