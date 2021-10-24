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
            $items = $page->getWorkExamples();
            foreach ($items as $item) {
                $item->setImages($this->files_explorer->getImagesFromFolder($item->getImgFolder()));
            }
        } else {
            $items = $this->getAll();
        }
        
        return $items;
    }
}