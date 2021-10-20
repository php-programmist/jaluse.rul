<?php

namespace App\Dto;

class BreadcrumbItemDto
{
    public function __construct(
        public string $name,
        public string $link
    ) {
    }
}