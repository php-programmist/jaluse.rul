<?php

namespace App\Service;

class FilesExplorerService
{
    private array $folders = [];
    
    /**
     * @param string $folder     - relative path from DOCUMENT_ROOT
     * @param array  $extensions - allowed file's extensions
     * @param bool   $full_path  - true: returns relative path from DOCUMENT_ROOT; false: returns relative path from $folder;
     * @param bool   $recursive  - true: get images from sub-folders
     *
     * @return array of files path
     */
    public function getFilesFromFolder(
        string $folder,
        array $extensions = [],
        bool $full_path = true,
        bool $recursive = false
    ): array {
        if (!file_exists($folder)) {
            $folder = $folder === '/' ? '' : ('/' . trim($folder, '/'));
            $source = $_SERVER['DOCUMENT_ROOT'] . $folder;
        } else {
            $source = $folder;
        }
        
        if (!file_exists($source)) {
            return [];
        }
        $source = rtrim($source, '/');
        $files  = $this->getFilesRecursive($source, $extensions, $recursive);
        
        foreach ($files as $key => $file_path) {
            if ( ! $full_path) {
                $files[$key] = str_replace($source . DIRECTORY_SEPARATOR, '', $file_path);
            } else {
                $files[$key] = str_replace(DIRECTORY_SEPARATOR, '/', $file_path);
            }
        }
        
        natsort($files);
        
        return $files;
    }
    
    /**
     * @param string $folder    - relative path from DOCUMENT_ROOT
     * @param bool   $full_path - true: returns relative path from DOCUMENT_ROOT; false: returns relative path from $folder;
     * @param bool   $recursive - true: get images from sub-folders
     *
     * @return array of images path
     */
    public function getImagesFromFolder(string $folder, bool $full_path = true, bool $recursive = false): array
    {
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        return $this->getFilesFromFolder($folder, $extensions, $full_path, $recursive);
    }
    
    /**
     * @param string $folder - relative path from DOCUMENT_ROOT
     * @param string $folder_for_concat - path that will be added to image name
     * @param int    $limit - maximum of images
     *
     * @return array of images path
     */
    public function getRandomImages(string $folder, string $folder_for_concat, int $limit): array
    {
        if (!isset($this->folders[$folder])) {
            $this->folders[$folder] = $this->getImagesFromFolder($folder, false);
            $this->folders[$folder] = array_flip($this->folders[$folder]);
        }
        $random_images = array_rand($this->folders[$folder], $limit);
        shuffle($random_images);
        
        return array_map(static function ($item) use ($folder_for_concat) {
            return $folder_for_concat . '/' . $item;
        }, $random_images);
    }
    
    private function getFilesRecursive($source, $extensions, $recursive): array
    {
        $files = [];
        if (is_dir($source) && $dh = opendir($source)) {
            while (($file = readdir($dh)) !== false) {
                if (@filetype($source . DIRECTORY_SEPARATOR . $file) === 'file') {
                    $extension = pathinfo($source . DIRECTORY_SEPARATOR . $file, PATHINFO_EXTENSION);
                
                    if (empty($extensions) || in_array($extension, $extensions, true)) {
                        $files[] = $source . DIRECTORY_SEPARATOR . $file;
                    }
                
                } elseif ($file !== '..' && $file !== '.' && $recursive && @filetype($source . DIRECTORY_SEPARATOR . $file) === 'dir') {
                    /** @noinspection SlowArrayOperationsInLoopInspection */
                    $files = array_merge($files,
                        $this->getFilesRecursive($source . DIRECTORY_SEPARATOR . $file, $extensions,
                            $recursive));
                }
            }
            closedir($dh);
        }
    
        return $files;
    }
}