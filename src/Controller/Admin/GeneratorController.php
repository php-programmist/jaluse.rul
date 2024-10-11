<?php

namespace App\Controller\Admin;

use App\Repository\LocationRepository;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/generator", name="admin_generator_")
 */
class GeneratorController extends AbstractController
{
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
    public function rating(
        PageRepository $content_repository,
        EntityManagerInterface $em,
        Request $request,
    )
    {
        $pages = $content_repository->findAll();
        foreach ($pages as $page) {
            $page->setRatingValue($page->getRandomRatingValue());
            $page->setRatingCount($page->getRandomRatingCount());
        }
        $em->flush();
        
        $this->addFlash('success','Рейтинги перегенерированы для страниц: '.count($pages));
        $referer = $request->headers->get('referer');
        
        return new RedirectResponse($referer);
    }
    
    /**
     * @Route("/location-title/", name="location_title")
     */
    public function locationTitle(
        LocationRepository $locationRepository,
        EntityManagerInterface $em,
        Request $request,
    ) {
        $locations = $locationRepository->findAll();
        $counter = 0;
        foreach ($locations as $location) {
            // Для дочерних страниц раздела zhalyuzi/pomeshheniya title указывается вручную
            if ($location->getParent()?->getUri() !== 'zhalyuzi/pomeshheniya') {
                $location->generateTitle();
                $counter++;
            }
        }
        $em->flush();
        
        $this->addFlash('success',
            sprintf('Title перегенерированы для помещений: %d. Внимание: дочерние страницы раздела "zhalyuzi/pomeshheniya" добавлены в исключения - для них title не изменился!',
                $counter));
        
        $referer = $request->headers->get('referer');
        
        return new RedirectResponse($referer);
    }
}
