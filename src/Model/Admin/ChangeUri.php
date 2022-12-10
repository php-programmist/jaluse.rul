<?php

namespace App\Model\Admin;

class ChangeUri
{
    private ?string $oldUri = null;
    
    private ?string $newUri = null;
    
    private bool $apply = false;
    
    /**
     * @return string|null
     */
    public function getOldUri(): ?string
    {
        return $this->oldUri;
    }
    
    /**
     * @param string|null $oldUri
     *
     * @return $this
     */
    public function setOldUri(?string $oldUri): self
    {
        $this->oldUri = $oldUri;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getNewUri(): ?string
    {
        return $this->newUri;
    }
    
    /**
     * @param string|null $newUri
     *
     * @return $this
     */
    public function setNewUri(?string $newUri): self
    {
        $this->newUri = $newUri;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isApply(): bool
    {
        return $this->apply;
    }
    
    /**
     * @param bool $apply
     *
     * @return $this
     */
    public function setApply(bool $apply): self
    {
        $this->apply = $apply;
        
        return $this;
    }
    
}