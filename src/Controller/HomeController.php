<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PageRepository $page_repository)
    {
        $page = $page_repository->find(1);
        return $this->render('home/index.html.twig',compact('page'));
    }
}
