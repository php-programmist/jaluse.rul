<?php

namespace App\Controller\Admin;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/generator", name="admin_generator_")
 */
class GeneratorController extends AbstractController
{
    
    /**
     * @var PageRepository
     */
    protected $content_repository;
    
    public function __construct(PageRepository $content_repository)
    {
        $this->content_repository = $content_repository;
    }
    
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/generator/index.html.twig');
    }
    
    /**
     * @Route("/rating/", name="rating")
     */
    public function rating(PageRepository $content_repository)
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $content_repository->findAll();
        foreach ($pages as $page) {
            $page->setRatingValue($page->getRandomRatingValue());
            $page->setRatingCount($page->getRandomRatingCount());
        }
        $em->flush();
        
        $this->addFlash('success','Рейтинги перегенерированы для страниц: '.count($pages));
        return $this->redirectToRoute('admin_generator_index');
    }
}
