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
        $host = $subDomainService->getHost();
    
        return $this->render('robots.txt.twig', compact('host'));
    }
}
