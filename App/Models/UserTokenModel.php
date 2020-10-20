<?php

namespace App\Models;

final class UserTokenModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $refreshToken;
    
    /**
     * @var string
     */
    private $expiredAt;

    /**
     * @var int
     */
    private $tenantId;

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
    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): UserTokenModel
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     * @return UserTokenModel
     */
    public function setRefreshToken(string $refreshToken): UserTokenModel
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     * @return string 
     */
    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    /**
     * @param string $tenantId
     * @return UserTokenModel
     */
    public function setTenantId(string $tenantId): UserTokenModel
    {
        $this->tenantId = $tenantId;
        return $this;
    }
}