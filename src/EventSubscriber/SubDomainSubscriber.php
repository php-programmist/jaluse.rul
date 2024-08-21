<?php

namespace App\EventSubscriber;

use App\Service\SubDomainService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SubDomainSubscriber implements EventSubscriberInterface
{
    
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
            KernelEvents::RESPONSE =>
                [
                    ['onKernelResponse'],
                ],
        ];
    }
    
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response      = $event->getResponse();
        if ($response instanceof BinaryFileResponse) {
            return;
        }
        $content       = $response->getContent();
        $substitutions = $this->subDomainService->getSubstitutions();
        foreach ($substitutions as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        $response->setContent($content);
    }
    
}