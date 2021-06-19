<?php

namespace App\Service;

use App\Entity\Color;
use App\Repository\ColorRepository;

class ColorManager
{
    private ColorRepository $colorRepository;
    
    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }
    
    /**
     * @return array|Color[]
     */
    public function getAllColors(): array
    {
        return $this->colorRepository->findBy([], ['id' => 'asc']);
    }
}