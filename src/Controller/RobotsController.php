<?php

namespace App\Controller;

use App\Service\SubDomainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RobotsController extends AbstractController
{
    /**
     * @Route("/robots.txt", name="robots", format="txt")
     */
    public function robots(SubDomainService $subDomainService)
    {
        $host     = $subDomainService->getHost();
        $response = $this->render('robots.txt.twig', compact('host'));
        $response->headers->set('Content-Type', 'text/plain');
        
        return $response;
    }
}
