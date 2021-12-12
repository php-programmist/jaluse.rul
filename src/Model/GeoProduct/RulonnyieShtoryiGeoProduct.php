<?php

namespace App\Model\GeoProduct;

class RulonnyieShtoryiGeoProduct extends AbstractGeoProduct
{
    public const TYPE = 'rulonnyie-shtoryi';
    
    protected $nameNominative = 'Рулонные шторы';
    protected $nameGenitive = 'рулонных штор';
    protected $cardImage = '/img/pomesheniia.jpg';
    protected $price = ''; //Заполняется из настроек geo.rulonnyie-shtoryi
    
}