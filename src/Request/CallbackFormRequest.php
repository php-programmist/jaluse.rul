<?php

namespace App\Request;

use App\Http\RequestDTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CallbackFormRequest implements RequestDTOInterface
{
    /**
     * @Assert\NotBlank(
     *     message="Укажите имя"
     *     )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "В имени должно быть минимум {{ limit }} символа",
     *      maxMessage = "В имени должно быть максимум {{ limit }} символов"
     * )
     * @Assert\Regex(
     *     "#[\da-zA-Z]#",
     *     match=false,
     *     message="Укажите корректное имя"
     *     )
     */
    public $name;
    /**
     * @Assert\NotBlank(
     *     message="Укажите телефон"
     *     )
     * @Assert\Regex(
     *     "#\+(7|8)\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}#",
     *     message="Укажите корректный телефон"
     *     )
     */
    public $phone;
    public $subject;
    public $referer;
    public $product_url;
    public $product_name;
    public $category;
    public $material;
    public $width;
    public $height;
    public $number;
    public $controlType;
    public $color;
    public $base_price;
    public $discounted_price;
    public $price_with_delivery;
    
    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
        if ($request->request->has('name')) {
            $this->name = trim($request->get('name'));
        } else {
            $this->name = "Не указано";
        }
        
        $this->phone               = trim($request->get('phone'));
        $this->subject             = trim($request->get('subject', 'Заказ звонка'));
        $this->referer             = $_SERVER['HTTP_REFERER'] ?? 'Нет';
        $this->product_url         = trim($request->get('product_url'));
        $this->product_name        = trim($request->get('product_name'));
        $this->category            = trim($request->get('category'));
        $this->material            = trim($request->get('material'));
        $this->width               = trim($request->get('width'));
        $this->height              = trim($request->get('height'));
        $this->number              = trim($request->get('number'));
        $this->controlType         = trim($request->get('controlType'));
        $this->color               = trim($request->get('color'));
        $this->base_price          = trim($request->get('base_price'));
        $this->discounted_price    = trim($request->get('discounted_price'));
        $this->price_with_delivery = trim($request->get('price_with_delivery'));
    }
    
}