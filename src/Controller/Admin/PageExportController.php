<?php

namespace App\Controller\Admin;

use App\Form\ProductExportType;
use App\Model\Admin\ProductExport;
use App\Service\ExportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class PageExportController extends AbstractController
{
    /**
     * @Route("/admin/product-export", name="admin_product_export")
     */
    public function products(Request $request, ExportManager $manager): Response
    {
        $productExport = new ProductExport();
        $form          = $this->createForm(ProductExportType::class, $productExport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                [$temp_file, $fileName] = $manager->exportProducts($productExport);
                
                return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
            } catch (Throwable $e){
                $this->addFlash('warning', $e->getMessage());
            }
        }
        
        return $this->render('admin/page-export/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}