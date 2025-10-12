<?php

namespace App\EventSubscriber;

use App\Service\SubDomainService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RedirectSubscriber implements EventSubscriberInterface
{
    
    /**
     * @param SubDomainService $subDomainService
     */
    public function __construct(
        private SubDomainService $subDomainService,
    ) {
    }
    
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST =>
                [
                    ['onKernelRequest'],
                ],
        ];
    }
    
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$event->isMainRequest() || $request->isXmlHttpRequest()) {
            return;
        }
        
        $path      = parse_url($request->getUri(), PHP_URL_PATH);
        $redirects = $this->subDomainService->getRedirects();
        
        $subdomain = $redirects[$path] ?? null;
        if (null !== $subdomain) {
            $url = $this->subDomainService->getSubDomainRoot($subdomain);
            $event->setResponse(new RedirectResponse($url));
            
            return;
        }
        
        // домен не является ни основным, ни существующим поддоменом из списка
        // В этом случае редиректим на основной домен
        if (
            !$this->subDomainService->isMainDomain()
            && null === $this->subDomainService->getSubdomainEntity()
        ) {
            $url = sprintf(
                '%s%s',
                $this->subDomainService->getDomainRoot(),
                $path
            );
            
            $event->setResponse(new RedirectResponse($url));
        }
    }
    
}