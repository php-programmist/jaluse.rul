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
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private string $cityNominative = '';
    
    /**
     * @ORM\Column(type="json")
     */
    private array $substitutions = [];
    
    /**
     * @ORM\Column(type="json")
     */
    private ?array $redirects = [];
    
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
    
    public function getRedirects(): array
    {
        return $this->redirects ?? [];
    }
    
    public function setRedirects(array $redirects): self
    {
        $this->redirects = $redirects;
        
        return $this;
    }
    
    public function getCityPrepositional(): string
    {
        return $this->substitutions['$city_prepositional'] ?? '';
    }
    
    public function setCityPrepositional(string $cityPrepositional): self
    {
        $this->substitutions['$city_prepositional'] = $cityPrepositional;
        
        return $this;
    }
    
    public function getCityAndRegionPrepositional(): string
    {
        return $this->substitutions['$city_and_region_prepositional'] ?? '';
    }
    
    public function setCityAndRegionPrepositional(string $cityAndRegionPrepositional): self
    {
        $this->substitutions['$city_and_region_prepositional'] = $cityAndRegionPrepositional;
        
        return $this;
    }
    
    public function getCityGenitive(): string
    {
        return $this->substitutions['$city_genitive'] ?? '';
    }
    
    public function setCityGenitive(string $cityGenitive): self
    {
        $this->substitutions['$city_genitive'] = $cityGenitive;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getCityNominative(): string
    {
        return $this->cityNominative;
    }
    
    /**
     * @param string $cityNominative
     *
     * @return $this
     */
    public function setCityNominative(string $cityNominative): self
    {
        $this->cityNominative = $cityNominative;
        
        return $this;
    }
    
    public function getMainPageUrl(): string
    {
        return sprintf('https://%s%s%s',
            $this->getName(),
            $this->getName() !== '' ? '.' : '',
            $_ENV['BASE_HOST']
        );
    }
}
