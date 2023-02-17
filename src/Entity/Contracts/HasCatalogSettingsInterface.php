<?php

namespace App\Entity\Contracts;

interface HasCatalogSettingsInterface
{
    public function getDefaultOrdering(): string;
    
    public function getProductsPerPage(): ?int;
}