<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
abstract class Geo extends Page
{
    public function getCardHeader(): string
    {
        return $this->getH1() . ' цена';
    }
    
    public function getCardDescription(): string
    {
        return '<p><span><b>Материал:</b> ткань, алюминий, пластик, дерево.</span> <span><b>Цвет:</b> на выбор.</span> <span><b>Размеры:</b> стандартные и под заказ</span> <span><b>Тип:</b> горизонтальные и вертикальные.</span> <span><b>Виды:</b> алюминиевые, пластиковые, деревянные, тканевые.</span> <span><b>Помещения:</b>&nbsp;терраса&nbsp;</span><span><b>Управление:</b> механическое и автоматическое</span> <span><b>Срок изготовления и установки:</b> 2-7 дней (зависит от сложности и объема).</span> <span><b>Замер:</b> бесплатный (при оформлении и оплате заказа).</span> <span><b>Доставка и установка жалюзи:</b> в Москве и Московской области.</span> <span>Возможна доставка и установка по России</span></p>';
    }
    
    public function getCardImageUrl(): string
    {
        return '/img/location/terrasa (1) (1).jpg';
    }
}