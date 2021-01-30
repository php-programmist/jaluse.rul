<?php

namespace App\Controller;

use App\Adapter\CatalogPageAdapter;
use App\Adapter\RssPageAdapter;
use App\Entity\Location;
use App\Repository\CatalogRepository;
use App\Repository\LocationRepository;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\BasePage;
use PhpProgrammist\YandexTurboRssGeneratorBundle\YandexTurboRssGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TurboPageController extends AbstractController
{

    /**
     * @Route("/turbo/locations.xml", name="turbo_pages_locations")
     * @param RssPageAdapter $adapter
     * @param LocationRepository $locationRepository
     * @param YandexTurboRssGenerator $generator
     * @return Response
     */
    public function locations(
        RssPageAdapter $adapter,
        LocationRepository $locationRepository,
        YandexTurboRssGenerator $generator
    ) {

        $base_page = new BasePage(
            'Жалюзи на пластиковые окна в Москве',
            'Жалюзи на пластиковые окна купить недорого в Москве. Выезд и замер бесплатно! Изготовление жалюзи с установкой за 1-4 дня. Гарантия 2 года. Жалюзи на пластиковые окна по низким ценам в интернет магазине «Мастерская жалюзи».  8-800-775-72-38.',
            '/zhalyuzi/'
        );
        $items = $locationRepository->findAll();
        $items = array_filter($items, static function(Location $location){
            return $location->getPath() !== '/zhalyuzi/santekhnicheskie/';
        });
        $adapter
            ->setBasePage($base_page)
            ->setOriginalItems($items);

        return $generator->render($adapter, $base_page);
    }
    
    /**
     * @Route("/turbo/catalogs.xml", name="turbo_pages_catalogs")
     * @param RssPageAdapter          $adapter
     * @param CatalogRepository       $catalogRepository
     * @param YandexTurboRssGenerator $generator
     *
     * @return Response
     */
    public function catalogs(
        CatalogPageAdapter $adapter,
        CatalogRepository $catalogRepository,
        YandexTurboRssGenerator $generator
    ) {

        $base_page = new BasePage(
            'Жалюзи на пластиковые окна в Москве',
            'Жалюзи на пластиковые окна купить недорого в Москве. Выезд и замер бесплатно! Изготовление жалюзи с установкой за 1-4 дня. Гарантия 2 года. Жалюзи на пластиковые окна по низким ценам в интернет магазине «Мастерская жалюзи».  8-800-775-72-38.',
            '/zhalyuzi/'
        );
        $items = $catalogRepository->findBy(['turbo' => true]);
        
        $adapter
            ->setBasePage($base_page)
            ->setOriginalItems($items);

        return $generator->render($adapter, $base_page);
    }

}
