<?php

namespace App\Service;

use App\Entity\Contracts\HasExamplesInterface;
use App\Entity\Page;
use App\Entity\WorkExample;
use App\Repository\WorkExampleRepository;

class WorkExampleService
{
    
    public function __construct(
        private WorkExampleRepository $workExampleRepository,
        private FilesExplorerService $files_explorer
    ) {
    }
    
    /**
     * @return WorkExample[]
     */
    public function getAll(): array
    {
        $items = $this->workExampleRepository->findBy([], ['position' => 'asc', 'id' => 'desc']);
        foreach ($items as $item) {
            $item->setImages($this->files_explorer->getImagesFromFolder($item->getImgFolder()));
        }
        
        return $items;
    }
    
    /**
     * @return WorkExample[]
     */
    public function getByPage(?Page $page): array
    {
        if ($page instanceof HasExamplesInterface) {
            $items = $page->getWorkExamplesOfPage()->toArray();
            $limit = $page->getWorkExamplesLimit();
    
            if ($limit > 0) {
                $items = array_slice($items, 0, $limit);
            }
    
            foreach ($items as $item) {
                $item->setImages($this->files_explorer->getImagesFromFolder($item->getImgFolder()));
            }
        } else {
            $items = $this->getAll();
        }
    
        return $items;
    }
    
    /**
     * @param array<WorkExample> $items
     *
     * @return array
     */
    public function getPossibleFilters(array $items): array
    {
        $toMerge = [];
        foreach ($items as $item) {
            $toMerge[] = $item->getFilters();
        }
        $filters = array_merge(...$toMerge);
        
        return array_unique($filters);
    }
}