<?php

namespace App\Controller;

use App\Model\YmlModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class YmlController extends AbstractController
{
    /**
     * @Route("/yml/index.xml", name="yml",format="xml")
     */
    public function index(YmlModel $model)
    {
        $offers         = $model->getOffers();
        $main_page_data = $model->getMainPageData();
        
        return $this->render('yml/index.xml.twig', [
            'offers'         => $offers,
            'main_page_data' => $main_page_data,
        ]);
    }
}
