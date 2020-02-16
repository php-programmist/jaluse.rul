<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SimplePageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    protected $page_repository;
    
    public function __construct(PageRepository $page_repository)
    {
        $this->page_repository = $page_repository;
    }
    
    /**
     * @Route("/zhalyuzi/pomeshheniya/", name="simple_page_pomeshheniya")
     */
    public function pomeshheniya(LocationRepository $location_repository)
    {
        $page = $this->page_repository->findOneBy(['uri'=>'zhalyuzi/pomeshheniya']);
        $items = $location_repository->findAll();
        return $this->render('simple_page/pomeshheniya.html.twig', [
            'page' => $page,
            'items' => $items,
        ]);
    }
}
