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
     * @Route("/kontaktyi/", name="simple_page_kontaktyi")
     */
    public function kontaktyi()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'kontaktyi']);
        return $this->render('simple_page/kontaktyi.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/o-kompanii/", name="simple_page_o_kompanii")
     */
    public function o_kompanii()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'o-kompanii']);
        return $this->render('simple_page/o_kompanii.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/zakaz-zhalyuzi/", name="simple_page_zakaz_zhalyuzi")
     */
    public function zakaz_zhalyuzi()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'zakaz-zhalyuzi']);
        return $this->render('simple_page/zakaz_zhalyuzi.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/video-jaluse/", name="simple_page_video_jaluse")
     */
    public function video_jaluse()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'video-jaluse']);
        return $this->render('simple_page/video_jaluse.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/optom/", name="simple_page_optom")
     */
    public function optom()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'optom']);
        return $this->render('simple_page/optom.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/confidence-policy/", name="simple_page_confidence-policy")
     */
    public function confidence_policy()
    {
        return $this->render('simple_page/confidence-policy.html.twig');
    }
    
    /**
     * @Route("/pay/", name="simple_page_pay")
     */
    public function pay()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'pay']);
        return $this->render('simple_page/pay.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/dostavka/", name="simple_page_dostavka")
     */
    public function dostavka()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'dostavka']);
        return $this->render('simple_page/dostavka.html.twig', [
            'page' => $page,
        ]);
    }
    
    /**
     * @Route("/uslugi/", name="simple_page_uslugi")
     */
    public function uslugi()
    {
        $page = $this->page_repository->findOneBy(['uri'=>'uslugi']);
        return $this->render('simple_page/uslugi.html.twig', [
            'page' => $page,
        ]);
    }
}