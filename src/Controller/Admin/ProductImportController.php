<?php

namespace App\Controller\Admin;

use App\Form\ProductImportType;
use App\Model\Admin\ProductImport;
use App\Service\ImportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ProductImportController extends AbstractController
{
    /**
     * @Route("/admin/product-import", name="admin_product_import_index")
     */
    public function index(Request $request, ImportManager $manager): Response
    {
        $productImport = new ProductImport();
        $form          = $this->createForm(ProductImportType::class, $productImport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                [$created, $updated] = $manager->importProducts($productImport);
            } catch (Throwable $e){
                $this->addFlash('warning', $e->getMessage());
            }
        }
        
        return $this->render('admin/product-import/index.html.twig', [
            'form'    => $form->createView(),
            'created' => $created ?? [],
            'updated' => $updated ?? [],
        ]);
    }
}