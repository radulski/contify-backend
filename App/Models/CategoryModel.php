<?php

namespace App\Models;

final class CategoryModel
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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $uid;
    
    /**
     * @return string 
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return CategoryModel
     */
    public function setCreatedAt(string $created_at): CategoryModel
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
     * @return CategoryModel
     */
    public function setEnable(string $enable): CategoryModel
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
     * @return CategoryModel
     */
    public function setTenantId(string $tenant_id): CategoryModel
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
     * @return CategoryModel
     */
    public function setUpdatedAt(string $updated_at): CategoryModel
    {
        $this->updated_at = $updated_at;
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
     * @param string $name
     * @return CategoryModel
     */
    public function setName(string $name): CategoryModel
    {
        $this->name = $name;
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
     * @return CategoryModel
     */
    public function setUid(string $uid): CategoryModel
    {
        $this->uid = $uid;
        return $this;
    }
}