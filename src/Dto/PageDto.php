<?php

namespace App\Dto;

class PageDto
{
    public function __construct(
        public string $path,
        public float $priority,
    )
    {
    }
    
}