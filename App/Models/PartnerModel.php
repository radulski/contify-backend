<?php

namespace App\Models;

final class PartnerModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $tenantId;
    
    /**
     * @var string
     */
    private $document;

    /**
     * @var string
     */
    private $jobDescription;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $complement;

    /**
     * @var string
     */
    private $neighborhood;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var int
     */
    private $integrationId;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PartnerModel
     */
    public function setName(string $name): PartnerModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string 
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @param string $document
     * @return PartnerModel
     */
    public function setDocument(string $document): PartnerModel
    {
        $this->document = $document;
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
     * @return PartnerModel
     */
    public function setUid(string $uid): PartnerModel
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return int 
     */
    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    /**
     * @param int $tenantId
     * @return PartnerModel
     */
    public function setTenantId(int $tenantId): PartnerModel
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * @return string 
     */
    public function getJobDescription(): string
    {
        return $this->jobDescription;
    }

    /**
     * @param string $jobDescription
     * @return PartnerModel
     */
    public function setJobDescription(string $jobDescription): PartnerModel
    {
        $this->jobDescription = $jobDescription;
        return $this;
    }

    /**
     * @return string 
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return PartnerModel
     */
    public function setZipCode(string $zipCode): PartnerModel
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string 
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return PartnerModel
     */
    public function setStreet(string $street): PartnerModel
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string 
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return PartnerModel
     */
    public function setNumber(string $number): PartnerModel
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string 
     */
    public function getComplement(): string
    {
        return $this->complement;
    }

    /**
     * @param string $complement
     * @return PartnerModel
     */
    public function setComplement(string $complement): PartnerModel
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @return string 
     */
    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    /**
     * @param string $neighborhood
     * @return PartnerModel
     */
    public function setNeighborhood(string $neighborhood): PartnerModel
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    /**
     * @return string 
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return PartnerModel
     */
    public function setCity(string $city): PartnerModel
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string 
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return PartnerModel
     */
    public function setState(string $state): PartnerModel
    {
        $this->state = $state;
        return $this;
    }

     /**
     * @return string 
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return PartnerModel
     */
    public function setPhone(string $phone): PartnerModel
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return int 
     */
    public function getIntegrationId(): int
    {
        return $this->integrationId;
    }

    /**
     * @param int $integrationId
     * @return PartnerModel
     */
    public function setIntegrationId(int $integrationId): PartnerModel
    {
        $this->integrationId = $integrationId;
        return $this;
    }
}