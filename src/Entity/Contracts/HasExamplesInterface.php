<?php

namespace App\Entity\Contracts;

use App\Entity\WorkExample;
use Doctrine\Common\Collections\Collection;

interface HasExamplesInterface
{
    /**
     * @return Collection<WorkExample>
     */
    public function getWorkExamplesOfPage(): Collection;
    
    public function getWorkExamplesLimit(): int;
}