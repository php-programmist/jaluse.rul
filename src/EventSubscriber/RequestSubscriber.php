<?php

namespace App\EventSubscriber;

use App\Entity\RobotsIp;
use Doctrine\ORM\EntityManagerInterface;
use ReCaptcha\ReCaptcha;
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
    
    private const SESSION_KEY_PASSED_CHECK = 'check.passed';
    
    private Environment $twig;
    private EntityManagerInterface $entityManager;
    private ReCaptcha $reCaptcha;
    
    /**
     * @param Environment            $twig
     * @param EntityManagerInterface $entityManager
     * @param ReCaptcha              $reCaptcha
     */
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        ReCaptcha $reCaptcha
    ) {
        $this->twig          = $twig;
        $this->entityManager = $entityManager;
        $this->reCaptcha     = $reCaptcha;
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
    
        $session = $request->getSession();
        if ($session->get(self::SESSION_KEY_PASSED_CHECK)) {
            //Проверка каптчи пройдена ранне
            return;
        }
    
        $robotsCheckResponse = $this->getRobotsCkeckResponse($request->getUri());
        $ip                  = $request->server->get('REMOTE_ADDR');
        $useragent           = $request->server->get('HTTP_USER_AGENT');
        $referer             = $request->server->get('HTTP_REFERER');
    
        $robotsIp = $this->getIpFromRobotsList($ip);
        if (null !== $robotsIp) {
            if ($robotsIp->isPassed()) {
                return;
            }
        
            $gRecaptchaResponse = $request->get('g-recaptcha-response');
            if (!empty($gRecaptchaResponse)) {
                $result = $this->reCaptcha
                    ->setExpectedHostname($request->getHost())
                    ->setScoreThreshold(0.8)
                    ->verify($gRecaptchaResponse, $request->getClientIp());
                if ($result->isSuccess()) { //Каптча пройдена успешно
                    $this->removeIpFromRobotsList($ip);
                    $session->set(self::SESSION_KEY_PASSED_CHECK, true);
                
                    return;
                }
            }
        
            $event->setResponse($robotsCheckResponse);
        
            return;
        }
    
        if ($this->isFromSocial($referer) || $this->isSuspicious($referer, $useragent)) {
            $this->saveIpToRobotsList($ip, $referer, $useragent);
            $event->setResponse($robotsCheckResponse);
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
    
    private function getIpFromRobotsList($ip): ?RobotsIp
    {
        return $this->entityManager
            ->getRepository(RobotsIp::class)
            ->findOneBy(['ip' => $ip]);
    }
    
    private function isFromSocial(?string $referer): bool
    {
        if (null === $referer) {
            return false;
        }
        $host = parse_url($referer, PHP_URL_HOST);
        if (empty($host)) {
            return false;
        }
        foreach (self::SOCIAL_REFERRERS as $ref) {
            if (strpos($host, $ref) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    private function saveIpToRobotsList(string $ip, ?string $referer = null, ?string $useragent = null): void
    {
        $ipList = $this->getIpFromRobotsList($ip);
        if (null === $ipList) {
            $robotsIp = (new RobotsIp())
                ->setIp($ip)
                ->setReferer($referer)
                ->setUserAgent($useragent);
            $this->entityManager->persist($robotsIp);
            $this->entityManager->flush();
        }
    }
    
    private function removeIpFromRobotsList(string $ip): void
    {
        $robotsIp = $this->getIpFromRobotsList($ip);
        if (null !== $robotsIp) {
            $robotsIp->setPassed(true);
            $this->entityManager->flush();
        }
    }
    
    private function isSuspicious(?string $referrer, ?string $useragent): bool
    {
        return empty($referrer)
               && !preg_match('#(yandex|google|mail|bing)#i', $useragent)
               && stripos($useragent, 'android') !== false;
    }
}