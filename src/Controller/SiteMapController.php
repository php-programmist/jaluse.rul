<?php

namespace App\Controller;

use App\Model\SiteMapModel;
use App\Service\SiteMapService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteMapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", format="xml")
     */
    public function xml(SiteMapService $siteMapService): Response
    {
        return new Response($siteMapService->show());
    }
    
    /**
     * @Route("/sitemap/", name="sitemap_html")
     */
    public function html(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $query      = $em->createQuery("SELECT a FROM App\Entity\Page as a WHERE a.published = 1 ORDER BY a.id");
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1000 /*limit per page*/
        );
        
        // parameters to template
        return $this->render('sitemap/index.html.twig', ['pagination' => $pagination]);
    }
}
