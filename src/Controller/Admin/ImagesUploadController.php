<?php

namespace App\Controller\Admin;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ImagesUploadController extends AbstractController
{
    /**
     * @Route("/admin/upload-images", name="admin_upload_images_index", methods={"GET"})
     */
    public function uploadImagesIndex(): Response
    {
        return $this->render('admin/images-upload/index.html.twig');
    }
    
    /**
     * @Route("/admin/upload-images", name="admin_upload_images", methods={"POST"})
     */
    public function uploadImages(Request $request, Security $security): JsonResponse
    {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['status' => 'ERROR', 'message' => 'Ошибка прав доступа']);
        }
        /** @var UploadedFile */
        $image_file   = $request->files->get('file');
        $root_folder  = $request->server->get('DOCUMENT_ROOT');
        $file_name    = $image_file->getClientOriginalName();
        $imagesFolder = '/img/articles';
        $folder       = $root_folder . $imagesFolder;
        try{
            if ($image_file->move($folder, $file_name)) {
                $response = ['status' => 'OK', 'message' => $imagesFolder . '/' . $file_name];
            } else {
                $response = ['status' => 'ERROR', 'message' => 'Ошибка при сохранении файла на диск'];
            }
        } catch (Exception $e){
            $response = ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
        
        return new JsonResponse($response);
    }
    
    /**
     * @Route("/admin/upload-images/cke", name="admin_upload_images_cke", methods={"POST"})
     */
    public function uploadImagesCke(Request $request, Security $security): JsonResponse
    {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['uploaded' => 0, 'error' => ['message' => 'Ошибка прав доступа']]);
        }
        /** @var UploadedFile */
        $image_file   = $request->files->get('upload');
        $root_folder  = $request->server->get('DOCUMENT_ROOT');
        $file_name    = $image_file->getClientOriginalName();
        $imagesFolder = '/img/articles';
        $folder       = $root_folder . $imagesFolder;
        try{
            if ($image_file->move($folder, $file_name)) {
                $response = ['uploaded' => 1, 'fileName' => $file_name, 'url' => $imagesFolder . '/' . $file_name];
            } else {
                $response = ['uploaded' => 0, 'error' => ['message' => 'Ошибка при сохранении файла на диск']];
            }
        } catch (Exception $e){
            $response = ['uploaded' => 0, 'error' => ['message' => $e->getMessage()]];
        }
        
        return new JsonResponse($response);
    }
    
    /**
     * @Route("/admin/delete-image", name="admin_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Request $request)
    {
        $root_folder = $request->server->get('DOCUMENT_ROOT');
        $file        = $request->request->get('file');
        
        if (!$file) {
            return new JsonResponse(['status' => false, 'msg' => 'Не указан файл для удаления']);
        }
        if (!file_exists($root_folder . $file) || is_dir($root_folder . $file)) {
            return new JsonResponse(['status' => false, 'msg' => 'Файл не существует']);
        }
        if (unlink($root_folder . $file)) {
            return new JsonResponse(['status' => true, 'msg' => 'Удалено']);
        }
        
        return new JsonResponse(['status' => false, 'msg' => 'Ошибка при удалении файла']);
    }
}