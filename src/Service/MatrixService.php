<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MatrixService
{
    const FOLDERS = [
        'mini',
        'uni',
        'combo-uni',
        'combo-small',
        'standart',
    ];
    const BASE_FOLDER = '/csv/matrix/';
    
    protected $project_dir;
    /**
     * @var FilesExplorerService
     */
    protected $explorer_service;
    /**
     * @var AdapterInterface
     */
    protected $cache;
    
    public function __construct(
        ParameterBagInterface $params,
        FilesExplorerService $explorer_service,
        AdapterInterface $cache
    ) {
        
        $this->project_dir      = $params->get('kernel.project_dir');
        $this->explorer_service = $explorer_service;
        $this->cache            = $cache;
    }
    
    public function getAllMatrices(): array
    {
        $matrices = [];
        foreach (self::FOLDERS as $folder) {
            $matrices[$folder] = $this->getMatrixSet($folder);
        }
        
        return $matrices;
    }
    
    public function getAllCachedMatrices(): array
    {
        $item = $this->cache->getItem('app.matrices_all');
        if (!$item->isHit()) {
            $matrices = $this->getAllMatrices();
            $item->set($matrices);
            $this->cache->save($item);
        }
        
        return $item->get();
    }
    
    public function getMatrixSet($folder): array
    {
        $path_to_folder = $this->project_dir . self::BASE_FOLDER . $folder;
        $files          = $this->explorer_service->getFilesFromFolder($path_to_folder, ['csv'], false);
        $matrixSet      = [];
        foreach ($files as $file) {
            $matrix_name             = pathinfo($file, PATHINFO_FILENAME);
            $matrixSet[$matrix_name] = $this->getMatrix($folder, $file);
        }
        
        return $matrixSet;
    }
    
    public function getMatrix($folder, $file): array
    {
        if (strpos($file, '.csv') === false) {
            $file .= '.csv';
        }
        $path_to_file = $this->project_dir . self::BASE_FOLDER . $folder . '/' . $file;
        $fh           = fopen($path_to_file, 'r');
        
        $matrix = [];
        while ($row = fgetcsv($fh, 8000, ';')) {
            if ( ! isset($width_list)) {
                $width_list = $row;
                continue;
            }
            foreach ($width_list as $index => $width) {
                $width = (float)$width * 1000;
                if ( ! $width) {
                    $height = (float)$row[0] * 1000;
                    continue;
                }
                if ( ! $height) {
                    continue;
                }
                $matrix[$width][$height] = $row[$index];
            }
        }
        
        return $matrix;
    }
}