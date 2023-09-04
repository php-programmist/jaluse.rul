<?php

namespace App\Entity;

use App\Repository\SubdomainRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubdomainRepository::class)
 */
class Subdomain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name = '';
    
    /**
     * @ORM\Column(type="json")
     */
    private array $substitutions = [];
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getSubstitutions(): array
    {
        return $this->substitutions ?? [];
    }
    
    public function setSubstitutions(array $substitutions): self
    {
        $this->substitutions = $substitutions;
        
        return $this;
    }
}
