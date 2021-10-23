<?php

namespace App\Entity\Traits;

use App\Entity\Calculator;
use App\Entity\Catalog;
use Doctrine\Common\Collections\Collection;

trait CatalogCalcTrait
{
    public function getCalcLink(): ?string
    {
        $currentPage = $this;
        
        for ($i = 1 ; $i <= 4 ; $i++) {
            $calculator = $this->getCalculator($currentPage->getPages());
            if (null !== $calculator) {
                break;
            }
            $currentPage = $currentPage->getParent();
            if (!$currentPage instanceof Catalog) {
                break;
            }
        }
        
        return $calculator?->getPath();
    }
    
    /**
     * @param Collection $children
     *
     * @return Calculator|null
     */
    protected function getCalculator(Collection $children): ?Calculator
    {
        $calculator = null;
        foreach ($children as $child) {
            if ($child instanceof Calculator) {
                $calculator = $child;
                break;
            }
        }
        
        return $calculator;
    }
}