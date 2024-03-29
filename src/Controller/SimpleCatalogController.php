<?php

namespace App\Controller;

use App\Entity\District;
use App\Model\GeoProduct\RulonnyieShtoryiGeoProduct;
use App\Model\GeoProduct\ZhalyuziGeoProduct;
use App\Repository\MarkizRepository;
use App\Repository\PageRepository;
use App\Repository\RollRepository;
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
        $page  = $this->page_repository->findOneBy(['uri' => 'markizyi']);
        $items = $repository->findAll();
        
        return $this->render('simple_catalog/markizyi/index.html.twig', [
            'page'  => $page,
            'items' => $items,
        ]);
    }
    
    /**
     * @Route("/rolstavni/", name="simple_catalog_rolstavni")
     */
    public function rolstavni(RollRepository $repository)
    {
        $page  = $this->page_repository->findOneBy(['uri' => 'rolstavni']);
        $items = $repository->findAll();
        
        return $this->render('simple_catalog/index.html.twig', [
            'page'  => $page,
            'items' => $items,
        ]);
    }
    
    /**
     * @Route("/shtory-dlya-besedok-i-verand/shtory-pvh/", name="simple_catalog_shtory-pvh")
     */
    public function shtory_pvh()
    {
        $page = $this->page_repository->findOneBy(['uri' => 'shtory-dlya-besedok-i-verand/shtory-pvh']);
        
        return $this->render('simple_catalog/index.html.twig', [
            'page'  => $page,
            'items' => [],
        ]);
    }
    
    /**
     * @Route("/districts/", name="simple_catalog_districts")
     */
    public function districts()
    {
        $page      = $this->page_repository->findOneBy(['uri' => 'districts']);
        $repo      = $this->getDoctrine()->getRepository(District::class);
        $districts = $repo->findBy(['parent' => null, 'geoProductType' => ZhalyuziGeoProduct::TYPE]);
    
        return $this->render('simple_catalog/districts.html.twig', [
            'page'      => $page,
            'districts' => $districts,
        ]);
    }
    
    /**
     * @Route("/rulonnyie-shtoryi/districts/", name="simple_catalog_rulonnyie_shtoryi_districts")
     */
    public function rulonnyieShtoryiDistricts()
    {
        $page      = $this->page_repository->findOneBy(['uri' => 'rulonnyie-shtoryi/districts']);
        $repo      = $this->getDoctrine()->getRepository(District::class);
        $districts = $repo->findBy(['parent' => null, 'geoProductType' => RulonnyieShtoryiGeoProduct::TYPE]);
        
        return $this->render('simple_catalog/districts.html.twig', [
            'page'      => $page,
            'districts' => $districts,
        ]);
    }
}
