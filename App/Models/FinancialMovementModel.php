<?php

namespace App\Models;

final class FinancialMovementModel
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
     * @var int
     */
    private $contact_id;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $year;

    /**
     * @var string
     */
    private $month;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var int
     */
    private $bank_account_id;

    /**
     * @var string
     */
    private $bank_account_uid;

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
    private $documentNumber;
    
    /**
     * @var string
     */
    private $movment_type;

    /**
     * @var string
     */
    private $category_name;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var int
     */
    private $transfer_id;

    /**
     * @var int
     */
    private $category_id;

     /**
     * @var int
     */
    private $launch_id;


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
     * @return FinancialMovementModel
     */
    public function setCreatedAt(string $created_at): FinancialMovementModel
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
     * @return FinancialMovementModel
     */
    public function setEnable(string $enable): FinancialMovementModel
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
     * @return FinancialMovementModel
     */
    public function setTenantId(string $tenant_id): FinancialMovementModel
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
     * @return FinancialMovementModel
     */
    public function setUpdatedAt(string $updated_at): FinancialMovementModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return string 
     */
    public function getContactId(): ?string
    {
        return $this->contact_id;
    }

    /**
     * @param string $contact_id
     * @return FinancialMovementModel
     */
    public function setContactId(?string $contact_id): FinancialMovementModel
    {
        $this->contact_id = $contact_id;
        return $this;
    }

    /**
     * @return string 
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return FinancialMovementModel
     */
    public function setDate(?string $date): FinancialMovementModel
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string 
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return FinancialMovementModel
     */
    public function setYear(string $year): FinancialMovementModel
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string 
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @param string $month
     * @return FinancialMovementModel
     */
    public function setMonth(string $month): FinancialMovementModel
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @return string 
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return FinancialMovementModel
     */
    public function setType(string $type): FinancialMovementModel
    {
        $this->type = $type;
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
     * @return FinancialMovementModel
     */
    public function setValue(float $value): FinancialMovementModel
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string 
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     * @return FinancialMovementModel
     */
    public function setNotes(?string $notes): FinancialMovementModel
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return int 
     */
    public function getBankAccountId(): ?int
    {
        return $this->bank_account_id;
    }

    /**
     * @param int $bank_account_id
     * @return FinancialMovementModel
     */
    public function setBankAccountId(?int $bank_account_id): FinancialMovementModel
    {
        $this->bank_account_id = $bank_account_id;
        return $this;
    }

    /**
     * @return string 
     */
    public function getBankAccountUid(): ?string
    {
        return $this->bank_account_uid;
    }

    /**
     * @param string $bank_account_uid
     * @return FinancialMovementModel
     */
    public function setBankAccountUid(?string $bank_account_uid): FinancialMovementModel
    {
        $this->bank_account_uid = $bank_account_uid;
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
     * @return FinancialMovementModel
     */
    public function setAgency(string $agency): FinancialMovementModel
    {
        $this->agency = $agency;
        return $this;
    }

    /**
     * @return string 
     */
    public function getAccount(): string
    {
        return $this->agency;
    }

    /**
     * @param string $account
     * @return FinancialMovementModel
     */
    public function setAccount(string $account): FinancialMovementModel
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string 
     */
    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     * @return FinancialMovementModel
     */
    public function setDocumentNumber(string $documentNumber): FinancialMovementModel
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }

    /**
     * @return string 
     */
    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     * @return FinancialMovementModel
     */
    public function setUid(?string $uid): FinancialMovementModel
    {
        $this->uid = $uid;
        return $this;
    }    

    /**
     * @return string 
     */
    public function getMovementType(): ?string
    {
        return $this->movement_type;
    }

    /**
     * @param string $movement_type
     * @return FinancialMovementModel
     */
    public function setMovementType(?string $movement_type): FinancialMovementModel
    {
        $this->movement_type = $movement_type;
        return $this;
    } 

    /**
     * @return string 
     */
    public function getCategoryName(): string
    {
        return $this->category_name;
    }

    /**
     * @param string $category_name
     * @return FinancialMovementModel
     */
    public function setCategoryName(string $category_name): FinancialMovementModel
    {
        $this->category_name = $category_name;
        return $this;
    } 

    /**
     * @return int 
     */
    public function getTransferId(): ?int
    {
        return $this->transfer_id;
    }

    /**
     * @param int $transfer_id
     * @return FinancialMovementModel
     */
    public function setTransferId(?int $transfer_id): FinancialMovementModel
    {
        $this->transfer_id = $transfer_id;
        return $this;
    }


    /**
     * @return int 
     */
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    /**
     * @param int $transfer_id
     * @return FinancialMovementModel
     */
    public function setCategoryId(?int $category_id): FinancialMovementModel
    {
        $this->category_id = $category_id;
        return $this;
    }

    /**
     * @return int 
     */
    public function getLaunchId(): ?int
    {
        return $this->launch_id;
    }

    /**
     * @param int $transfer_id
     * @return FinancialMovementModel
     */
    public function setLaunchId(?int $launch_id): FinancialMovementModel
    {
        $this->launch_id = $launch_id;
        return $this;
    }

    
}