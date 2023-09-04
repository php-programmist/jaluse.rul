<?php

namespace App\Service;

use App\Entity\Subdomain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SubDomainService
{
    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private string $baseHost,
    ) {
    }
    
    public function getSubDomain(): string
    {
        $request = $this->requestStack->getMainRequest();
        $host    = $request?->headers->get('Host');
        if (null === $host) {
            return '';
        }
        
        return trim(str_replace($this->baseHost, '', $host), '.');
    }
    
    public function getSubstitutions(): array
    {
        $subdomain = $this->entityManager
            ->getRepository(Subdomain::class)
            ->findOneBy(['name' => $this->getSubDomain()]);
    
        if (null === $subdomain) {
            return [];
        }
    
        return $subdomain->getSubstitutions();
    }
    
    public function isMainDomain(): bool
    {
        return '' === $this->getSubDomain();
    }
    
}