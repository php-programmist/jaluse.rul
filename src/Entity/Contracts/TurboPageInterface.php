<?php

namespace App\Entity\Contracts;

use DateTimeInterface;

interface TurboPageInterface
{
    public function getPath():string;
    
    public function getH1(): string;
    
    public function getCardHeader(): string;
    
    public function getCardImageUrl(): string;
    
    public function getTextComputed(): string;
    
    public function getModifyDate(): ?DateTimeInterface;
    
    public function getTurboContentTemplate(): string;
    
    public function getCalcLink(): ?string;
}