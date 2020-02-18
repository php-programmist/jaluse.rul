<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location extends Page
{
    public function getCardImgFolder()
    {
        return 'img/location/';
    }
}
