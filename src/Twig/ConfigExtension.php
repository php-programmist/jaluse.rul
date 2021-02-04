<?php

namespace App\Twig;

use App\Service\ConfigService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ConfigExtension extends AbstractExtension
{
    /**
     * @var ConfigService
     */
    private $configService;
    
    /**
     * @param ConfigService $configService
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_config', [$this, 'get'], ['is_safe' => ['html']]),
            new TwigFunction('get_config_cached', [$this, 'getCached'], ['is_safe' => ['html']]),
        ];
    }
    
    /**
     * @param string $param_name
     * @param null   $default
     *
     * @return string
     */
    public function get(string $param_name, $default = null): string
    {
        return $this->configService->get($param_name, $default);
    }
    
    /**
     * @param string $param_name
     * @param null   $default
     *
     * @return string
     */
    public function getCached(string $param_name, $default = null): string
    {
        return $this->configService->getCached($param_name, $default);
    }
    
}
