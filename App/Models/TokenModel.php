<?php

namespace App\Models;

final class TokenModel
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
     * @var string
     */
    private $cnpj;

    /**
     * @var string
     */
    private $token;

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
     * @return TokenModel
     */
    public function setCreatedAt(string $created_at): TokenModel
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
     * @return TokenModel
     */
    public function setEnable(string $enable): TokenModel
    {
        $this->enable = $enable;
        return $this;
    }

    /**
     * @return string 
     */
    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     * @return TokenModel
     */
    public function setCnpj(string $cnpj): TokenModel
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * @return string 
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return TokenModel
     */
    public function setToken(string $token): TokenModel
    {
        $this->token = $token;
        return $this;
    }
}

