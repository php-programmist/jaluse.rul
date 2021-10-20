<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Config;
use App\Entity\Page;
use App\Repository\PageRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private AdapterInterface $cache,
        private PageRepository $pageRepository,
    ) {
    }
    
    /**
     * Returns an array of event names this subscriber wants to listen to.
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            'easy_admin.post_update'          => ['clearCache'],
            BeforeEntityPersistedEvent::class => ['setParent'],
        );
    }
    
    /**
     * Устанавливает родителя для сущности, если родитель не задан
     *
     * @param BeforeEntityPersistedEvent $event
     */
    public function setParent(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        
        if (!$entity instanceof Page || null !== $entity->getParent()) {
            return;
        }
        $parentUri = match ($entity::class) {
            Article::class => 'articles',
            default => '/'
        };
        $parent    = $this->pageRepository->findOneBy(['uri' => $parentUri]);
        $entity->setParent($parent);
    }
    
    public function clearCache(GenericEvent $event): void
    {
        $entity = $event->getSubject();
        
        if (!($entity instanceof Config)) {
            return;
        }
        $this->cache->clear();
    }
}