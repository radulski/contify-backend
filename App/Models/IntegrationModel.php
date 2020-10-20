<?php

namespace App\Models;

final class IntegrationModel
{
    /**
     * @var int
     */
    private $id;

     /**
     * @var string
     */
    private $integrated;

    /**
     * @var string
     */
    private $integratedAt;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @return int 
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return boolean 
     */
    public function getIntegrated(): string
    {
        return $this->integrated;
    }

    /**
     * @param string $integrated
     * @return IntegrationModel
     */
    public function setIntegrated(string $integrated): IntegrationModel
    {
        $this->integrated = $integrated;
        return $this;
    }

    /**
     * @return string 
     */
    public function getIntegratedAt(): string
    {
        return $this->integratedAt;
    }

    /**
     * @param string $integratedAt
     * @return IntegrationModel
     */
    public function setIntegratedAt(string $integratedAt): IntegrationModel
    {
        $this->integratedAt = $integratedAt;
        return $this;
    }

    /**
     * @return string 
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     * @return IntegrationModel
     */
    public function setTableName(string $tableName): IntegrationModel
    {
        $this->tableName = $tableName;
        return $this;
    }
}