<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CategoryManager
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private UrlGeneratorInterface $urlGenerator,
        private RequestStack $requestStack,
    ) {
    
    }
    
    /**
     * @return array|Category[]
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findBy([], ['id' => 'asc']);
    }
    
    public function findCategoryByNameOrFail(string $name): Category
    {
        if (!$category = $this->categoryRepository->findOneBy(['name' => $name])) {
            throw new NotFoundHttpException();
        }
        
        return $category;
    }
    
    public function getCategoriesFilterLinks(Catalog $catalog): array
    {
        $query = $this->requestStack->getCurrentRequest()?->query->all();
        
        $categories = $this->getAllCategories();
        $links      = [];
        foreach ($categories as $category) {
            $catName         = $category->getName();
            $params          = array_merge(
                $query, [
                'token'    => $catalog->getUri(),
                'category' => strtolower($catName),
            ]);
            $links[$catName] = $this->urlGenerator->generate('catalog_filter_category', $params);
        }
        
        return $links;
    }
}