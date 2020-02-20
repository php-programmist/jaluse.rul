<?php

namespace App\Controller;

use App\Repository\MarkizRepository;
use App\Repository\PageRepository;
use App\Repository\RollRepository;
use App\Repository\RomanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SimpleCatalogController extends AbstractController
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
     * @Route("/markizyi/", name="simple_catalog_markizyi")
     */
    public function markizyi(MarkizRepository $repository)
    {
        $page = $this->page_repository->findOneBy(['uri'=>'markizyi']);
        $items = $repository->findAll();
        return $this->render('simple_catalog/index.html.twig', [
            'page' => $page,
            'items' => $items,
        ]);
    }
    
    /**
     * @Route("/rolstavni/", name="simple_catalog_rolstavni")
     */
    public function rolstavni(RollRepository $repository)
    {
        $page = $this->page_repository->findOneBy(['uri'=>'rolstavni']);
        $items = $repository->findAll();
        return $this->render('simple_catalog/index.html.twig', [
            'page' => $page,
            'items' => $items,
        ]);
    }
    
    /**
     * @Route("/rimskies/", name="simple_catalog_rimskies")
     */
    public function rimskies(RomanRepository $repository)
    {
        $page = $this->page_repository->findOneBy(['uri'=>'rimskies']);
        $items = $repository->findAll();
        return $this->render('simple_catalog/index.html.twig', [
            'page' => $page,
            'items' => $items,
            'area' => true,
        ]);
    }
    
    /**
     * @Route("/zhalyuzi/pomeshheniya/", name="simple_catalog_pomeshheniya")
     */
    public function pomeshheniya()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'zhalyuzi/pomeshheniya']);
        $items = $page->getPages();
        return $this->render('simple_catalog/pomeshheniya.html.twig', [
            'page' => $page,
            'items' => $items,
        ]);
    }
    
    /**
     * @Route("/rulonnyie-shtoryi/pomeshheniya/", name="simple_catalog_pomeshheniya_rulonnyie")
     */
    public function pomeshheniya_rulonnyie()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'rulonnyie-shtoryi/pomeshheniya']);
        $items = $page->getPages();
        return $this->render('simple_catalog/pomeshheniya.html.twig', [
            'page' => $page,
            'items' => $items,
        ]);
    }
}
