<?php

namespace App\Models;

final class TaxGuideModel
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
    private $year;

    /**
     * @var string
     */
    private $month;

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
     * @return TaxGuideModel
     */
    public function setCreatedAt(string $created_at): TaxGuideModel
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
     * @return TaxGuideModel
     */
    public function setEnable(string $enable): TaxGuideModel
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
     * @return TaxGuideModel
     */
    public function setTenantId(string $tenant_id): TaxGuideModel
    {
        $this->tenant_id = $tenant_id;
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
     * @param string $tenant_id
     * @return TaxGuideModel
     */
    public function setYear(string $year): TaxGuideModel
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
     * @param string $tenant_id
     * @return TaxGuideModel
     */
    public function setMonth(string $month): TaxGuideModel
    {
        $this->month = $month;
        return $this;
    }

    
}