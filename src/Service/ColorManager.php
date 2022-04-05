<?php

namespace App\Service;

use App\Entity\Color;
use App\Entity\Product;
use App\Repository\ColorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ColorManager
{
    private ColorRepository $colorRepository;
    private EntityManagerInterface $entityManager;
    
    public function __construct(ColorRepository $colorRepository, EntityManagerInterface $entityManager)
    {
        $this->colorRepository = $colorRepository;
        $this->entityManager   = $entityManager;
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
    
    /**
     * @param array $filters
     *
     * @return array|Color[]
     */
    public function getAvailableColors(array $filters): array
    {
        $allColors = $this->getAllColors();
    
        $availableColorsIds = $this->entityManager->getRepository(Product::class)->getAvailableColors($filters);
    
        return array_filter($allColors,
            static fn(Color $color) => in_array($color->getId(), $availableColorsIds,
                false));
    }
}