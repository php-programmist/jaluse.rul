<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatalogRepository")
 */
class Catalog extends Page
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matrix_folder;

    public function getMatrixFolder(): ?string
    {
        return $this->matrix_folder;
    }

    public function setMatrixFolder(?string $matrix_folder): self
    {
        $this->matrix_folder = $matrix_folder;

        return $this;
    }
}
