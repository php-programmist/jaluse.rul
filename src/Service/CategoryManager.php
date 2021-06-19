<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;

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
}