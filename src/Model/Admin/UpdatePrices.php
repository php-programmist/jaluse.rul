<?php

namespace App\Model\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdatePrices
{
    private ?UploadedFile $xlsFile = null;
    
    /**
     * @return UploadedFile|null
     */
    public function getXlsFile(): ?UploadedFile
    {
        return $this->xlsFile;
    }
    
    /**
     * @param UploadedFile|null $xlsFile
     *
     * @return $this
     */
    public function setXlsFile(?UploadedFile $xlsFile): self
    {
        $this->xlsFile = $xlsFile;
        
        return $this;
    }
    
}