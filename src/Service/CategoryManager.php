<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryManager
{
    private CategoryRepository $categoryRepository;
    
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
}