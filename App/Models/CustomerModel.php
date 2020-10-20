<?php

namespace App\Models;

final class CustomerModel
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $tenant_id;

    /**
     * @var string
     */
    private $created_at;

     /**
     * @var string
     */
    private $updated_at;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string|null
     */
    private $person_type;
    /**
     * @var string
     */
    private $document;
    /**
     * @var string
     */
    private $state_registration_number;
    /**
     * @var date
     */
    private $date_of_birth;
    /**
     * @var string
     */
    private $notes;
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
     * @return CustomerModel
     */
    public function setName(string $name): CustomerModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string 
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CustomerModel
     */
    public function setEmail(?string $email): CustomerModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string 
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return CustomerModel
     */
    public function setPhone(?string $phone): CustomerModel
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPersonType(): ?string
    {
        return $this->person_type;
    }

    public function setPersonType(?string $person_type): CustomerModel
    {
        $this->person_type = $person_type;
        return $this;
    }

    /**
     * @return string 
     */
    public function getDocument(): ?string
    {
        return $this->document;
    }

    /**
     * @param string $document
     * @return CustomerModel
     */
    public function setDocument(?string $document): CustomerModel
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string 
     */
    public function getStateRegistrationNumber(): ?string
    {
        return $this->state_registration_number;
    }

    /**
     * @param string $state_registration_number
     * @return CustomerModel
     */
    public function setStateRegistrationNumber(?string $state_registration_number): CustomerModel
    {
        $this->state_registration_number = $state_registration_number;
        return $this;
    }

    /**
     * @return string 
     */
    public function getDateOfBirth(): ?string
    {
        return $this->date_of_birth;
    }

    /**
     * @param string $date_of_birth
     * @return CustomerModel
     */
    public function setDateOfBirth(?string $date_of_birth): CustomerModel
    {
        $this->date_of_birth = $date_of_birth;
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
     * @return CustomerModel
     */
    public function setNotes(?string $notes): CustomerModel
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string 
     */
    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     * @return CustomerModel
     */
    public function setZipCode(?string $zip_code): CustomerModel
    {
        $this->zip_code = $zip_code;
        return $this;
    }

    /**
     * @return string 
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return CustomerModel
     */
    public function setStreet(?string $street): CustomerModel
    {
        $this->street = $street;
        return $this;
    }
   
    /**
     * @return string 
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return CustomerModel
     */
    public function setNumber(?string $number): CustomerModel
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string 
     */
    public function getComplement(): ?string
    {
        return $this->complement;
    }

    /**
     * @param string $number
     * @return CustomerModel
     */
    public function setComplement(?string $complement): CustomerModel
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @return string 
     */
    public function getNeighborhood(): ?string
    {
        return $this->neighborhood;
    }

    /**
     * @param string $neighborhood
     * @return CustomerModel
     */
    public function setNeighborhood(?string $neighborhood): CustomerModel
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    /**
     * @return string 
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return CustomerModel
     */
    public function setCity(?string $city): CustomerModel
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string 
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return CustomerModel
     */
    public function setState(?string $state): CustomerModel
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
     * @return CustomerModel
     */
    public function setUid(string $uid): CustomerModel
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return int 
     */
    public function getTenantId(): int
    {
        return $this->tenant_id;
    }

    /**
     * @param int $tenant_id
     * @return CustomerModel
     */
    public function setTenantId(int $tenant_id): CustomerModel
    {
        $this->tenant_id = $tenant_id;
        return $this;
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
     * @return CustomerModel
     */
    public function setCreatedAt(string $created_at): CustomerModel
    {
        $this->created_at = $created_at;
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
     * @return CustomerModel
     */
    public function setUpdatedAt(string $updated_at): CustomerModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}

