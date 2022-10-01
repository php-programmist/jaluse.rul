<?php

namespace App\Model\Admin;

use App\Entity\Catalog;

interface SlugConfig
{
    public function getCatalog(): ?Catalog;
    
    public function getRemoveFromName(): ?string;
    
    public function getBaseUri(): ?string;
}