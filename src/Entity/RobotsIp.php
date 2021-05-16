<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RobotsIp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=15, unique=true)
     * @var string
     */
    private $ip;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var ?string
     */
    private $referer;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var ?string
     */
    private $userAgent;
    
    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $passed = false;
    
    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     * @var DateTime
     */
    private $createdAt;
    
    /**
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }
    
    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getReferer(): ?string
    {
        return $this->referer;
    }
    
    /**
     * @param string|null $referer
     *
     * @return $this
     */
    public function setReferer(?string $referer): self
    {
        $this->referer = $referer;
        
        return $this;
    }
    
    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }
    
    /**
     * @param string|null $userAgent
     *
     * @return $this
     */
    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }
    
    /**
     * @param bool $passed
     *
     * @return $this
     */
    public function setPassed(bool $passed): self
    {
        $this->passed = $passed;
        
        return $this;
    }
    
}