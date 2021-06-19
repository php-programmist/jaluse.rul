<?php

namespace App\Twig;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SliderExtension extends AbstractExtension
{
    private $server_root;
    private EntityManagerInterface $entityManager;
    
    public function __construct(ParameterBagInterface $params, EntityManagerInterface $entityManager)
    {
        $this->server_root   = $params->get('kernel.project_dir') . '/' . $params->get('web_root');
        $this->entityManager = $entityManager;
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('swiper_slider', [$this, 'swiper_slider'],
                ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('getFilesFromFolder', [$this, 'getFilesFromFolder']),
            new TwigFunction('recommendedMainPage', [$this, 'recommendedMainPage'],
                ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }
    
    public function swiper_slider(Environment $twig,$folder)
    {
        $files = $this->getFilesFromFolder($folder);
        if (empty($files)) {
            return '';
        }
        
        return $twig->render('extension/swiper_slider.html.twig', compact('files'));
    }
    
    public function getFilesFromFolder($folder):array
    {
        if (empty($folder)) {
            return [];
        }
        $folder    = '/' . trim($folder,' /');
        $full_path = $this->server_root . $folder;
        if ( ! file_exists($full_path)) {
            return [];
        }
        $finder = new Finder();
        $finder->files()->in($full_path)->sortByName(true);
        $files = [];
        foreach ($finder as $file) {
            $files[] = $folder . '/' . $file->getRelativePathname();
        }
        
        return $files;
    }
    
    public function recommendedMainPage(Environment $twig)
    {
        $uris  = [
            'zhalyuzi/vertikalnye/tkanevye/lajn-ii-belyj',
            'zhalyuzi/vertikalnye/plastikovyie/plastikovie-vertikalnie-zhalyuzi-standart-309',
            'zhalyuzi/gorizontalnye/alyuminievye/1009',
            'zhalyuzi/isolite/1443',
            'zhalyuzi/gorizontalnye/derevyannye/derevo-242',
            'zhalyuzi/vertikalnye/tkanevye/lajn-ii-sinij1',
            'zhalyuzi/vertikalnye/plastikovyie/plastikovie-vertikalnie-zhalyuzi-standart-307',
            'zhalyuzi/gorizontalnye/alyuminievye/35',
            'zhalyuzi/isolite/443',
            'zhalyuzi/gorizontalnye/derevyannye/derevo-232',
        ];
        $items = $this->entityManager->getRepository(Product::class)->findByUris($uris);
        
        return $twig->render('modules/recommended_products.html.twig', [
            'items' => $items,
        ]);
    }
}
