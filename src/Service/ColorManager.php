<?php

namespace App\Service;

use App\Entity\Color;
use App\Repository\ColorRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    
    public function findColorByAliasOrFail(string $alias): Color
    {
        if (!$color = $this->colorRepository->findOneBy(['alias' => $alias])) {
            throw new NotFoundHttpException();
        }
        
        return $color;
    }
}