<?php

namespace App\Models;

final class ServiceInvoiceBatchModel
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
    private $year_purchase;

    /**
     * @var string
     */
    private $month_purchase;
    
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
     * @return ServiceInvoiceBatchModel
     */
    public function setCreatedAt(string $created_at): ServiceInvoiceBatchModel
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
     * @return ServiceInvoiceBatchModel
     */
    public function setEnable(string $enable): ServiceInvoiceBatchModel
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
     * @return ServiceInvoiceBatchModel
     */
    public function setTenantId(string $tenant_id): ServiceInvoiceBatchModel
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    /**
     * @return string 
     */
    public function getYearPurchase(): string
    {
        return $this->year_purchase;
    }

    /**
     * @param string $tenant_id
     * @return ServiceInvoiceBatchModel
     */
    public function setYearPurchase(string $year_purchase): ServiceInvoiceBatchModel
    {
        $this->year_purchase = $year_purchase;
        return $this;
    }

     /**
     * @return string 
     */
    public function getMonthPurchase(): string
    {
        return $this->month_purchase;
    }

    /**
     * @param string $tenant_id
     * @return ServiceInvoiceBatchModel
     */
    public function setMonthPurchase(string $month_purchase): ServiceInvoiceBatchModel
    {
        $this->month_purchase = $month_purchase;
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
     * @return ServiceInvoiceBatchModel
     */
    public function setUid(string $uid): ServiceInvoiceBatchModel
    {
        $this->uid = $uid;
        return $this;
    }
}