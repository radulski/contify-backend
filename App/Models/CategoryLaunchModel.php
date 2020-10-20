<?php

namespace App\Models;

final class CategoryLaunchModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $tenantId;
    
    /**
     * @var int
     */
    private $category_id;
    
    /**
     * @var int
     */
    private $launch_id;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $value;

    /**
     * @return int 
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return CategoryLaunchModel
     */
    public function setTenantId(int $tenantId): CategoryLaunchModel
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * @return int 
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     * @return CategoryLaunchModel
     */
    public function setCategoryId(int $category_id): CategoryLaunchModel
    {
        $this->category_id = $category_id;
        return $this;
    }

    /**
     * @return int 
     */
    public function getLaunchId(): string
    {
        return $this->launch_id;
    }

    /**
     * @param int $tenantId
     * @return CategoryLaunchModel
     */
    public function setLaunchId(int $launch_id): CategoryLaunchModel
    {
        $this->launch_id = $launch_id;
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
     * @return CategoryLaunchModel
     */
    public function setUid(string $uid): CategoryLaunchModel
    {
        $this->uid = $uid;
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
     * @return CategoryLaunchModel
     */
    public function setValue(float $value): CategoryLaunchModel
    {
        $this->value = $value;
        return $this;
    }
}