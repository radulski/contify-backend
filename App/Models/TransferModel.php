<?php

namespace App\Models;

final class TransferModel
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
     * @var string
     */
    private $updated_at;
    
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
    private $name;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var float
     */
    private $value;

    /**
     * @var int
     */
    private $bank_account_id;

    /**
     * @var int
     */
    private $batch_transfer_id;

    /**
     * @var int
     */
    private $type_transfer_bank_account_id;

    /**
     * @var int
     */
    private $origin_bank_account_id;

     /**
     * @var int
     */
    private $destination_bank_account_id;

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
     * @return TransferModel
     */
    public function setCreatedAt(string $created_at): TransferModel
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
     * @return TransferModel
     */
    public function setEnable(string $enable): TransferModel
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
     * @return TransferModel
     */
    public function setTenantId(string $tenant_id): TransferModel
    {
        $this->tenant_id = $tenant_id;
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
     * @param string $uid
     * @return TransferModel
     */
    public function setUid(string $uid): TransferModel
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return string 
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $uid
     * @return TransferModel
     */
    public function setName(string $name): TransferModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float 
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return CategoryLaunchModel
     */
    public function setValue(float $value): TransferModel
    {
        $this->value = $value;
        return $this;
    }


    public function getBankAccountId(): string
    {
        return $this->bank_account_id;
    }

    /**
     * @param string $uid
     * @return TransferModel
     */
    public function setBankAccountId(string $bank_account_id): TransferModel
    {
        $this->bank_account_id = $bank_account_id;
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
     * @param string $created_at
     * @return TransferModel
     */
    public function setUpdatedAt(string $updated_at): TransferModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getBatchTransferId(): string
    {
        return $this->batch_transfer_id;
    }

    /**
     * @param string $uid
     * @return TransferModel
     */
    public function setBatchTransferId(string $batch_transfer_id): TransferModel
    {
        $this->batch_transfer_id = $batch_transfer_id;
        return $this;
    }

    public function getTypeTransferBankAccountId(): string
    {
        return $this->type_transfer_bank_account_id;
    }

    /**
     * @param string $uid
     * @return TransferModel
     */
    public function setTypeTransferBankAccountId(string $type_transfer_bank_account_id): TransferModel
    {
        $this->type_transfer_bank_account_id = $type_transfer_bank_account_id;
        return $this;
    }

    /**
     * @return int 
     */
    public function getOriginBankAccountId(): int
    {
        return $this->origin_bank_account_id;
    }

     /**
     * @return string 
     */
    public function setOriginBankAccountId(int $origin_bank_account_id): TransferModel
    {
        $this->origin_bank_account_id = $origin_bank_account_id;
        return $this;
    }

     /**
     * @return int 
     */
    public function getDestinationBankAccountId(): int
    {
        return $this->destination_bank_account_id;
    }

     /**
     * @return string 
     */
    public function setDestinationBankAccountId(int $destination_bank_account_id): TransferModel
    {
        $this->destination_bank_account_id = $destination_bank_account_id;
        return $this;
    }
}