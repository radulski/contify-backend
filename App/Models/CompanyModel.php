<?php

namespace App\Models;

final class CompanyModel
{
    /**
     * @var int
     */
    private $id;


    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $document;

    /**
     * @var string
     */
    private $taxRegime;

    /**
     * @var string
     */
    private $quantity_employee;

    /**
     * @var string
     */
    private $zip_code;

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
     * @return CompanyModel
     */
    public function setName($name): CompanyModel
    {
        //echo 'nome: ' . $name;
      
        
        
        if ($name && !is_string($name)) {
            //echo 'here';
            throw new \InvalidArgumentException("O nome da empresa é obrigatório", 400);
        }
        

        $this->name = $name;
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
     * @return CompanyModel
     */
    public function setPhone(string $phone): CompanyModel
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string 
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CompanyModel
     */
    public function setEmail(string $email): CompanyModel
    {
        $this->email = $email;
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
     * @return CompanyModel
     */
    public function setDocument(string $document): CompanyModel
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string 
     */
    public function getTaxRegime(): string
    {
        return $this->taxRegime;
    }

    /**
     * @param string $taxRegime
     * @return CompanyModel
     */
    public function setTaxRegime(string $taxRegime): CompanyModel
    {
        $this->taxRegime = $taxRegime;
        return $this;
    }

    /**
     * @return string 
     */
    public function getQuantityEmployee(): string
    {
        return $this->quantity_employee;
    }

    /**
     * @param string $quantity_employee
     * @return CompanyModel
     */
    public function setQuantityEmployee(string $taxRegime): CompanyModel
    {
        $this->quantity_employee = $quantity_employee;
        return $this;
    }

    /**
     * @return string 
     */
    public function getZipCode(): string
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     * @return CompanyModel
     */
    public function setZipCode(string $zip_code): CompanyModel
    {
        $this->zip_code = $zip_code;
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
     * @return CompanyModel
     */
    public function setStreet(string $street): CompanyModel
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
     * @return CompanyModel
     */
    public function setNumber(string $number): CompanyModel
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
     * @param string $number
     * @return CompanyModel
     */
    public function setComplement(string $complement): CompanyModel
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
     * @return CompanyModel
     */
    public function setNeighborhood(string $neighborhood): CompanyModel
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
     * @return CompanyModel
     */
    public function setCity(string $city): CompanyModel
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
     * @return CompanyModel
     */
    public function setState(string $state): CompanyModel
    {
        $this->state = $state;
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
     * @return CompanyModel
     */
    public function setUid(string $uid): CompanyModel
    {
        $this->uid = $uid;
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
     * @return CompanyModel
     */
    public function setIntegrationId(int $integrationId): CompanyModel
    {
        $this->integrationId = $integrationId;
        return $this;
    }
}