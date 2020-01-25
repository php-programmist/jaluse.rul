<?php

namespace App\Service;

class FilesExplorerService
{
    private $folders = [];
    
    /**
     * @param string $folder    - relative path from DOCUMENT_ROOT
     * @param array  $extensions - allowed file's extensions
     * @param bool   $full_path - true: returns relative path from DOCUMENT_ROOT; false: returns relative path from $folder;
     * @param bool   $recursive - true: get images from subfolders
     *
     * @return array of files path
     */
    public function getFilesFromFolder($folder, $extensions = [], $full_path = true, $recursive = false)
    {
        if ( ! file_exists($folder)) {
            $folder = $folder === '/' ? '' : ('/' . trim($folder, '/'));
            $source = $_SERVER['DOCUMENT_ROOT'] . $folder;
        } else {
            $source = $folder;
        }
        
        if ( ! file_exists($source)) {
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
     * @param string $folder - relative path from DOCUMENT_ROOT
     * @param bool $full_path - true: returns relative path from DOCUMENT_ROOT; false: returns relative path from $folder;
     * @param bool $recursive - true: get images from subfolders
     *
     * @return array of images path
     */
    public function getImagesFromFolder(string $folder, $full_path = true, $recursive = false)
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
    public function getRandomImages(string $folder,string $folder_for_concat,int $limit)
    {
        if ( ! isset($this->folders[$folder])) {
            $this->folders[$folder] = $this->getImagesFromFolder($folder, false);
            $this->folders[$folder] = array_flip($this->folders[$folder]);
        }
        $random_images = array_rand($this->folders[$folder], $limit);
        shuffle($random_images);
        $random_images = array_map(function ($item) use ($folder_for_concat) {
            return $folder_for_concat . '/' . $item;
        }, $random_images);
        
        return $random_images;
    }
    
    private function getFilesRecursive($source, $extensions, $recursive): array
    {
        $files = [];
        if (is_dir($source)) {
            if ($dh = opendir($source)) {
                while (($file = readdir($dh)) !== false) {
                    if (@filetype($source . DIRECTORY_SEPARATOR . $file) == 'file') {
                        $extension = pathinfo($source . DIRECTORY_SEPARATOR . $file, PATHINFO_EXTENSION);
                        
                        if (empty($extensions) || in_array($extension, $extensions)) {
                            $files[] = $source . DIRECTORY_SEPARATOR . $file;
                        }
                        
                    } elseif (@filetype($source . DIRECTORY_SEPARATOR . $file) == 'dir' && $recursive && $file !== '.' && $file !== '..') {
                        $files = array_merge($files,
                            $this->getFilesRecursive($source . DIRECTORY_SEPARATOR . $file, $extensions,
                                $recursive));
                    }
                }
                closedir($dh);
            }
        }
        
        return $files;
    }
}