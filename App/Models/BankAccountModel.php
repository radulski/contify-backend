<?php

namespace App\Models;

final class BankAccountModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var boolean
     */

    private $enable;
    /**
     * @var int
     */

    private $tenant_id;
    /**
     * @var string
     */

    private $updated_at;
    /**
     * @var string
     */

    private $bank_code;
    /**
     * @var string
     */

    private $bank_name;
    /**
     * @var string
     */

    private $agency;
    /**
     * @var string
     */

    private $account;
    /**
     * @var string
     */

    private $document_number;
    /**
     * @var string
     */
    private $uid;

    /**
     * @return int 
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string 
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return BankAccountModel
     */
    public function setCreatedAt(string $created_at): BankAccountModel
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string 
     */
    public function getEnable(): string
    {
        return $this->enable;
    }

    /**
     * @param string $enable
     * @return BankAccountModel
     */
    public function setEnable(string $enable): BankAccountModel
    {
        $this->enable = $enable;
        return $this;
    }

    /**
     * @return string 
     */
    public function getTenantId(): string
    {
        return $this->tenant_id;
    }

    /**
     * @param string $tenant_id
     * @return BankAccountModel
     */
    public function setTenantId(string $tenant_id): BankAccountModel
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    /**
     * @return string 
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return BankAccountModel
     */
    public function setUpdatedAt(string $updated_at): BankAccountModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return string 
     */
    public function getBankCode(): string
    {
        return $this->bank_code;
    }

    /**
     * @param string $bank_code
     * @return BankAccountModel
     */
    public function setBankCode(string $bank_code): BankAccountModel
    {
        $this->bank_code = $bank_code;
        return $this;
    }

    /**
     * @return string 
     */
    public function getBankName(): string
    {
        return $this->bank_name;
    }

    /**
     * @param string $bank_name
     * @return BankAccountModel
     */
    public function setBankName(string $bank_name): BankAccountModel
    {
        $this->bank_name = $bank_name;
        return $this;
    }

    /**
     * @return string 
     */
    public function getAgency(): string
    {
        return $this->agency;
    }

    /**
     * @param string $agency
     * @return BankAccountModel
     */
    public function setAgency(string $agency): BankAccountModel
    {
        $this->agency = $agency;
        return $this;
    }

    /**
     * @return string 
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @param string $account
     * @return BankAccountModel
     */
    public function setAccount(string $account): BankAccountModel
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string 
     */
    public function getDocumentNumber(): string
    {
        return $this->document_number;
    }

    /**
     * @param string $document_number
     * @return BankAccountModel
     */
    public function setDocumentNumber(string $document_number): BankAccountModel
    {
        $this->document_number = $document_number;
        return $this;
    }

    /**
     * @return string 
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $account
     * @return BankAccountModel
     */
    public function setUid(string $uid): BankAccountModel
    {
        $this->uid = $uid;
        return $this;
    }

    

}



    