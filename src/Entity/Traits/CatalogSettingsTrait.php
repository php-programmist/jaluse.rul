<?php

namespace App\Entity\Traits;

trait CatalogSettingsTrait
{
    public function getDefaultOrdering(): string
    {
        return $this->getSetting('default_ordering') ?? 'price';
    }
    
    public function getProductsPerPage(): ?int
    {
        return $this->getSetting('products_per_page');
    }
}