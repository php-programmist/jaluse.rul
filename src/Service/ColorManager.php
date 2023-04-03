<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Color;
use App\Entity\Product;
use App\Repository\ColorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ColorManager
{
    
    public function __construct(
        private ColorRepository $colorRepository,
        private EntityManagerInterface $entityManager,
        private UrlGeneratorInterface $urlGenerator,
        private RequestStack $requestStack,
    ) {
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
    public function getAvailableColors(array $filters, Catalog $catalog): array
    {
        $query = $this->requestStack->getCurrentRequest()?->query->all();
        
        $availableColorsWithProducts = $this->entityManager->getRepository(Product::class)->getAvailableColorsWithProducts($filters);
        
        $ids    = array_map(static fn(array $data) => $data['id'], $availableColorsWithProducts);
        $colors = $this->entityManager->getRepository(Color::class)->findBy(['id' => $ids]);
        
        foreach ($colors as $color) {
            $colorData = current(
                array_filter($availableColorsWithProducts, static fn(array $data) => $data['id'] === $color->getId())
            );
            if (false === $colorData) {
                continue;
            }
            $color->setProductsCount($colorData['products']);
            
            $params = array_merge(
                $query, [
                'token' => $catalog->getUri(),
                'color' => $color->getAlias(),
            ]);
            $color->setLink($this->urlGenerator->generate('catalog_filter_color', $params));
        }
        
        return $colors;
    }
}