<?php

namespace App\Models;

final class AttachmentModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var boolean
     */

    private $enable;
    /**
     * @var int
     */

    private $tenantId;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $fileSize;

    /**
     * @var string
     */
    private $fileType;

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
        return $this->createdAt;
    }

    /**
     * @param string $created_at
     * @return AttachmentModel
     */
    public function setCreatedAt(string $createdAt): AttachmentModel
    {
        $this->createdAt = $createdAt;
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
     * @return AttachmentModel
     */
    public function setEnable(string $enable): AttachmentModel
    {
        $this->enable = $enable;
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
     * @return AttachmentModel
     */
    public function setTenantId(string $tenantId): AttachmentModel
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * @return string 
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $tenantId
     * @return AttachmentModel
     */
    public function setFileName(string $fileName): AttachmentModel
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return string 
     */
    public function getFileSize(): string
    {
        return $this->fileSize;
    }

    /**
     * @param string $tenantId
     * @return AttachmentModel
     */
    public function setFileSize(string $fileSize): AttachmentModel
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * @return string 
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }

    /**
     * @param string $tenantId
     * @return AttachmentModel
     */
    public function setFileType(string $fileType): AttachmentModel
    {
        $this->fileType = $fileType;
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
     * @return AttachmentModel
     */
    public function setUid(string $uid): AttachmentModel
    {
        $this->uid = $uid;
        return $this;
    }
}




