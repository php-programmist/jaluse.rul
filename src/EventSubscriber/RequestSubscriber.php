<?php

namespace App\EventSubscriber;

use App\Entity\RobotsIp;
use App\Service\RecaptchaValidator;
use Doctrine\ORM\EntityManagerInterface;
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
        'facebook.com',
        't.co',
        'twitter.com',
        'my.mail.ru',
    ];
    
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var string
     */
    private $recaptchaPublicKey;
    /**
     * @var RecaptchaValidator
     */
    private $validator;
    
    /**
     * @param Environment            $twig
     * @param EntityManagerInterface $entityManager
     * @param RecaptchaValidator     $validator
     * @param string                 $recaptchaPublicKey
     */
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        RecaptchaValidator $validator,
        string $recaptchaPublicKey
    ) {
        $this->twig               = $twig;
        $this->entityManager      = $entityManager;
        $this->recaptchaPublicKey = $recaptchaPublicKey;
        $this->validator          = $validator;
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
        
        $robotsCheckResponse = $this->getRobotsCkeckResponse($request->getUri());
        $ip                  = $request->server->get('REMOTE_ADDR');
        if ($this->isInRobotsIpsList($ip)) {
            if ($this->validator->isValid()) { //Каптча пройдена успешно
                $this->removeIpToRobotsList($ip);
                
                return;
            }
            $event->setResponse($robotsCheckResponse);
            
            return;
        }
        
        $referer = $request->server->get('HTTP_REFERER');
        if (empty($referer)) {
            return;
        }
        
        $host = parse_url($referer, PHP_URL_HOST);
        
        if ($this->isFromSocial($host)) {
            $this->saveIpToRobotsList($ip, $referer);
            $event->setResponse($robotsCheckResponse);
        }
    }
    
    private function getRobotsCkeckResponse(string $uri)
    {
        $content  = $this->twig->render('robots-check.html.twig', [
            'uri'       => $uri,
            'publicKey' => $this->recaptchaPublicKey,
        ]);
        $response = new Response();
        $response->setContent($content);
        
        return $response;
    }
    
    private function isInRobotsIpsList(string $ip): bool
    {
        return null !== $this->getIpFromRobotsList($ip);
    }
    
    private function getIpFromRobotsList($ip): ?RobotsIp
    {
        return $this->entityManager
            ->getRepository(RobotsIp::class)
            ->findOneBy(['ip' => $ip]);
    }
    
    private function isFromSocial(string $host): bool
    {
        foreach (self::SOCIAL_REFERRERS as $ref) {
            if (strpos($host, $ref) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    private function saveIpToRobotsList(string $ip, ?string $referer = null): void
    {
        if (!$this->isInRobotsIpsList($ip)) {
            $robotsIp = (new RobotsIp())
                ->setIp($ip)
                ->setReferer($referer);
            $this->entityManager->persist($robotsIp);
            $this->entityManager->flush();
        }
    }
    
    private function removeIpToRobotsList(string $ip): void
    {
        $robotsIp = $this->getIpFromRobotsList($ip);
        if (null !== $robotsIp) {
            $this->entityManager->remove($robotsIp);
            $this->entityManager->flush();
        }
    }
}