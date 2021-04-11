<?php

namespace App\Adapter;

use App\Entity\Contracts\TurboPageInterface;

class LocationPageAdapter extends RssPageAdapter
{
    protected function getText(TurboPageInterface $page): string
    {
        return $this->twig->render('turbo/locations/content.html.twig', [
            'page' => $page,
        ]);
    }
}