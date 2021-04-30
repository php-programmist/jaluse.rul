<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class RequestSubscriber implements EventSubscriberInterface
{
    private const SOCIAL_REFERRERS = [
        'vk.com',
        'instagram.com',
        'ok.ru',
        'fb.com',
        'twitter.com',
        'my.mail.ru',
    ];
    
    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
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
        if (!$event->isMasterRequest() || $request->isXmlHttpRequest()) {
            return;
        }
        
        $referer = $request->server->get('HTTP_REFERER');
        if (empty($referer)) {
            return;
        }
        $host = parse_url($referer, PHP_URL_HOST);
        
        foreach (self::SOCIAL_REFERRERS as $ref) {
            if (strpos($host, $ref) !== false) {
                $event->setResponse($this->getRobotsCkeckResponse($request->getUri()));
                
                return;
            }
        }
    }
    
    private function getRobotsCkeckResponse(string $uri)
    {
        $content  = $this->twig->render('robots-check.html.twig', [
            'uri' => $uri,
        ]);
        $response = new Response();
        $response->setContent($content);
        
        return $response;
    }
}