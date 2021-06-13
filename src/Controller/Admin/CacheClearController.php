<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CacheClearController extends EasyAdminController
{
    protected AdapterInterface $cache;
    
    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * @Route("/admin/cache-clear", name="admin_cache_clear")
     */
    public function cacheClearAction(): JsonResponse
    {
        if ($this->cache->clear()) {
            return $this->json(['status' => true, 'msg' => 'Кэш очищен']);
        }
        
        return $this->json(['status' => false, 'msg' => 'Произошла ошибка']);
    }
    
}