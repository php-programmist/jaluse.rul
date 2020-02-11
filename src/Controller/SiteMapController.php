<?php

namespace App\Controller;

use App\Model\SiteMapModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteMapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap",format="xml")
     */
    public function index(SiteMapModel $model)
    {
        $pages = $model->getPages();
        return $this->render('sitemap/index.xml.twig', [
            'pages' => $pages,
        ]);
    }
}
