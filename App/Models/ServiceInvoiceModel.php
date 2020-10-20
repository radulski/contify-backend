<?php

namespace App\Models;

final class ServiceInvoiceModel
{
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
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */

    private $totalValue;

    /**
     * @var string
     */

    private $issuanceDate;

    /**
     * @var int
     */

    private $batchInvoiceId;

    /**
     * @return string 
     */

    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return ServiceInvoiceModel
     */
    public function setYear(string $year): ServiceInvoiceModel
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
     * @return ServiceInvoiceModel
     */
    public function setMonth(string $month): ServiceInvoiceModel
    {
        $this->month = $month;
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
     * @return ServiceInvoiceModel
     */
    public function setCity(string $city): ServiceInvoiceModel
    {
        $this->city = $city;
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
     * @return ServiceInvoiceModel
     */
    public function setNumber(string $number): ServiceInvoiceModel
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string 
     */
    public function getTotalValue(): string
    {
        return $this->totalValue;
    }

    /**
     * @param string $totalValue
     * @return ServiceInvoiceModel
     */
    public function setTotalValue(string $totalValue): ServiceInvoiceModel
    {
        $this->totalValue = $totalValue;
        return $this;
    }

    /**
     * @return string 
     */
    public function getIssuanceDate(): string
    {
        return $this->issuanceDate;
    }

    /**
     * @param string $issuanceDate
     * @return ServiceInvoiceModel
     */
    public function setIssuanceDate(string $issuanceDate): ServiceInvoiceModel
    {
        $this->issuanceDate = $issuanceDate;
        return $this;
    }

    /**
     * @return int 
     */
    public function getBatchInvoiceId(): int
    {
        return $this->batchInvoiceId;
    }

    /**
     * @param int $batchInvoiceId
     * @return ServiceInvoiceModel
     */
    public function setBatchInvoiceId(int $batchInvoiceId): ServiceInvoiceModel
    {
        $this->batchInvoiceId = $batchInvoiceId;
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
     * @return ServiceInvoiceModel
     */
    public function setTenantId(string $tenant_id): ServiceInvoiceModel
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }
}