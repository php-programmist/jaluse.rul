<?php

namespace App\Model\Admin;

use App\Entity\Catalog;

class ProductExport
{
    private ?Catalog $catalog = null;
    
    /**
     * @return Catalog|null
     */
    public function getCatalog(): ?Catalog
    {
        return $this->catalog;
    }
    
    /**
     * @param Catalog|null $catalog
     *
     * @return $this
     */
    public function setCatalog(?Catalog $catalog): self
    {
        $this->catalog = $catalog;
        
        return $this;
    }
    
}