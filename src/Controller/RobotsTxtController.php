<?php

namespace App\Controller;

use App\Service\RobotsTxtService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RobotsTxtController
{
    #[Route('/robots.txt', 'robots_txt', format: 'txt')]
    public function xml(RobotsTxtService $robotsTxtService): Response
    {
        return new Response($robotsTxtService->show());
    }
}