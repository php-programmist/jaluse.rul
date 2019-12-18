<?php

namespace App\Service;

use App\Repository\ConfigRepository;

class ConfigService
{
    /**
     * @var ConfigRepository
     */
    protected $config_repository;
    
    public function __construct(ConfigRepository $config_repository)
    {
        $this->config_repository = $config_repository;
    }
    
    public function get($param_name, $default = null)
    {
        $config_entity = $this->config_repository->findOneBy(['name'=>$param_name]);
        return $config_entity?$config_entity->getValue():$default;
    }
}