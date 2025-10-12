<?php

namespace App\Service;

use App\Entity\Subdomain;
use Doctrine\ORM\EntityManagerInterface;
use Redis;
use Symfony\Component\HttpFoundation\RequestStack;

class SubDomainService
{
    private const CACHE_KEY = 'redirects';
    private const CACHE_TTL = 60 * 5;
    
    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private Redis $redis,
        private string $baseHost,
    ) {
    }
    
    public function getSubDomain(): string
    {
        $host = $this->getHost();
        if ('' === $host) {
            return '';
        }
    
        return trim(str_replace($this->baseHost, '', $host), '.');
    }
    
    public function getSubstitutions(): array
    {
        $subdomain = $this->getSubdomainEntity();
    
        if (null === $subdomain) {
            return [];
        }
    
        return $subdomain->getSubstitutions();
    }
    
    public function isMainDomain(): bool
    {
        return '' === $this->getSubDomain();
    }
    
    /**
     * @throws \JsonException
     */
    public function getRedirects(): array
    {
        $data = $this->redis->get(self::CACHE_KEY);
        if (false === $data) {
            $redirects = $this->findRedirects();
            $this->redis->setex(self::CACHE_KEY, self::CACHE_TTL, json_encode($redirects, JSON_THROW_ON_ERROR));
        } else {
            $redirects = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        }
        
        return $redirects;
    }
    
    private function findRedirects(): array
    {
        $subdomains = $this->entityManager
            ->getRepository(Subdomain::class)
            ->findAll();
        
        $redirects = [];
        foreach ($subdomains as $subdomain) {
            if (empty($subdomain->getRedirects())) {
                continue;
            }
            foreach ($subdomain->getRedirects() as $path) {
                $redirects[$path] = $subdomain->getName();
            }
        }
    
        return $redirects;
    }
    
    public function getSubDomainRoot(string $subdomain): string
    {
        return sprintf('https://%s.%s', $subdomain, $this->baseHost);
    }
    
    public function getDomainRoot(): string
    {
        return sprintf('https://%s', $this->baseHost);
    }
    
    public function getHost(): string
    {
        $request = $this->requestStack->getMainRequest();
        
        return $request?->headers->get('Host') ?? '';
    }
    
    /**
     * @return Subdomain[]
     */
    public function getSubdomains(): array
    {
        return $this->entityManager
            ->getRepository(Subdomain::class)
            ->findBy([], ['id' => 'asc']);
    }
    
    public function getSubdomainEntity(): ?Subdomain
    {
        return $this->entityManager
            ->getRepository(Subdomain::class)
            ->findOneBy(['name' => $this->getSubDomain()]);
    }
}