<?php

namespace App\Dto;

use App\Model\PriceListModel;

class YmlOfferDto
{
    public $id;
    public $path;
    public $meta_title;
    public $meta_description;
    public $hours;
    
    public function getPrice()
    {
        return round($this->hours * PriceListModel::PRICE_HOUR);
    }
}