<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SliderExtension extends AbstractExtension
{
    private $server_root;
    
    public function __construct( ParameterBagInterface $params)
    {
        $this->server_root = $params->get('kernel.project_dir').'/'.$params->get('web_root');
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('swiper_slider', [$this, 'swiper_slider'],
                ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('getFilesFromFolder', [$this, 'getFilesFromFolder']),
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
        $folder = '/'.trim($folder,' /');
        $full_path = $this->server_root.$folder;
        if ( ! file_exists($full_path)) {
            return [];
        }
        $finder = new Finder();
        $finder->files()->in($full_path)->sortByName(true);
        $files = [];
        foreach ($finder as $file) {
            $files[] = $folder.'/'.$file->getRelativePathname();
        }
        return $files;
    }
}
