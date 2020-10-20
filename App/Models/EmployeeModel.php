<?php

namespace App\Models;

final class EmployeeModel
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
    private $full_name;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $salary;

    /**
     * @var string
     */
    private $admissionDate;

    /**
     * @var string
     */
    private $startTimeStartPeriodMonToFri;

    /**
     * @var string
     */
    private $endTimeStartPeriodMonToFri;

    /**
     * @var string
     */
    private $startTimeEndPeriodMonToFri;

    /**
     * @var string
     */
    private $endTimeEndPeriodMonToFri;

    /**
     * @var string
     */
    private $startTimeSaturday;

    /**
     * @var string
     */
    private $endTimeSaturday;

    /**
     * @return string 
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return EmployeeModel
     */
    public function setCreatedAt(string $created_at): EmployeeModel
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
     * @return EmployeeModel
     */
    public function setEnable(string $enable): EmployeeModel
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
     * @return EmployeeModel
     */
    public function setTenantId(string $tenant_id): EmployeeModel
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

     /**
     * @return string 
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @param string $name
     * @return EmployeeModel
     */
    public function setFullName(string $full_name): EmployeeModel
    {
        $this->full_name = $full_name;
        return $this;
    }

     /**
     * @return string 
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return EmployeeModel
     */
    public function setCpf(string $cpf): EmployeeModel
    {
        $this->cpf = $cpf;
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
     * @return EmployeeModel
     */
    public function setUid(string $uid): EmployeeModel
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return string 
     */
    public function getSalary(): string
    {
        return $this->salary;
    }

    /**
     * @param string $salary
     * @return EmployeeModel
     */
    public function setSalary(string $salary): EmployeeModel
    {
        $this->salary = $salary;
        return $this;
    }

    /**
     * @return string 
     */
    public function getAdmissionDate(): string
    {
        return $this->admissionDate;
    }

    /**
     * @param string $admissionDate
     * @return EmployeeModel
     */
    public function setAdmissionDate(string $admissionDate): EmployeeModel
    {
        $this->admissionDate = $admissionDate;
        return $this;
    }

    /**
     * @return string 
     */
    public function getStartTimeStartPeriodMonToFri(): string
    {
        return $this->startTimeStartPeriodMonToFri;
    }

    /**
     * @param string $startTimeStartPeriodMonToFri
     * @return EmployeeModel
     */
    public function setStartTimeStartPeriodMonToFri(string $startTimeStartPeriodMonToFri): EmployeeModel
    {
        $this->startTimeStartPeriodMonToFri = $startTimeStartPeriodMonToFri;
        return $this;
    }

    /**
     * @return string 
     */
    public function getEndTimeStartPeriodMonToFri(): string
    {
        return $this->endTimeStartPeriodMonToFri;
    }

    /**
     * @param string $endTimeStartPeriodMonToFri
     * @return EmployeeModel
     */
    public function setEndTimeStartPeriodMonToFri(string $endTimeStartPeriodMonToFri): EmployeeModel
    {
        $this->endTimeStartPeriodMonToFri = $endTimeStartPeriodMonToFri;
        return $this;
    }

    /**
     * @return string 
     */
    public function getStartTimeEndPeriodMonToFri(): string
    {
        return $this->startTimeEndPeriodMonToFri;
    }

    /**
     * @param string $startTimeEndPeriodMonToFri
     * @return EmployeeModel
     */
    public function setStartTimeEndPeriodMonToFri(string $startTimeEndPeriodMonToFri): EmployeeModel
    {
        $this->startTimeEndPeriodMonToFri = $startTimeEndPeriodMonToFri;
        return $this;
    }

    /**
     * @return string 
     */
    public function getEndTimeEndPeriodMonToFri(): string
    {
        return $this->endTimeEndPeriodMonToFri;
    }

    /**
     * @param string $endTimeEndPeriodMonToFri
     * @return EmployeeModel
     */
    public function setEndTimeEndPeriodMonToFri(string $endTimeEndPeriodMonToFri): EmployeeModel
    {
        $this->endTimeEndPeriodMonToFri = $endTimeEndPeriodMonToFri;
        return $this;
    }

    /**
     * @return string 
     */
    public function getStartTimeSaturday(): string
    {
        return $this->startTimeSaturday;
    }

    /**
     * @param string $startTimeSaturday
     * @return EmployeeModel
     */
    public function setStartTimeSaturday(string $startTimeSaturday): EmployeeModel
    {
        $this->startTimeSaturday = $startTimeSaturday;
        return $this;
    }

    /**
     * @return string 
     */
    public function getEndTimeSaturday(): string
    {
        return $this->endTimeSaturday;
    }

    /**
     * @param string $endTimeSaturday
     * @return EmployeeModel
     */
    public function setEndTimeSaturday(string $endTimeSaturday): EmployeeModel
    {
        $this->endTimeSaturday = $endTimeSaturday;
        return $this;
    }
}