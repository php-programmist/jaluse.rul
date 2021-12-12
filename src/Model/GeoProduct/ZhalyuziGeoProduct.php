<?php

namespace App\Model\GeoProduct;

class ZhalyuziGeoProduct extends AbstractGeoProduct
{
    public const TYPE = 'zhalyuzi';
    
    protected $nameNominative = 'Жалюзи';
    protected $nameGenitive = 'жалюзи';
    protected $cardImage = '/img/location/terrasa (1) (1).jpg';
    protected $price = ''; //Заполняется из настроек geo.zhalyuzi
}