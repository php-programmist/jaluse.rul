<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use App\Repository\ColorRepository;
use App\Repository\ConfigRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use App\Service\ConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/main-page-calc", name="main_page_calc_")
 */
class MainPageCalcController extends AbstractController
{
    
    /**
     * @var ProductRepository
     */
    protected $product_repository;
    /**
     * @var TypeRepository
     */
    protected $type_repository;
    /**
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * @var ColorRepository
     */
    protected $color_repository;
    /**
     * @var CategoryRepository
     */
    protected $category_repository;
    /**
     * @var ConfigService
     */
    protected $configs;
    
    public function __construct(
        ProductRepository $product_repository,
        TypeRepository $type_repository,
        SerializerInterface $serializer,
        ColorRepository $color_repository,
        CategoryRepository $category_repository,
        ConfigService $configs
    ) {
        $this->product_repository  = $product_repository;
        $this->type_repository     = $type_repository;
        $this->serializer          = $serializer;
        $this->color_repository    = $color_repository;
        $this->category_repository = $category_repository;
        $this->configs             = $configs;
    }
    
    /**
     * @Route("/getInitData", name="init")
     */
    public function getInitData()
    {
        $types           = $this->getInitTypeData();
        $colors          = $this->getInitColors();
        $categories      = $this->getInitCategories();
        $usd_rate        = $this->configs->get('usd_rate', 62.5);
        $discount_global = $this->configs->get('discount_global', 7);
        
        $response = compact('types', 'colors', 'categories', 'usd_rate', 'discount_global');
        $response = json_encode($response);
        return new Response($response, 200, ['Content-Type' => 'application/json']);
    }
    
    /**
     * @Route("/getProducts", name="get_products")
     */
    public function getInitProducts(Request $request)
    {
        $filters       = [];
        $filters_names = ['type', 'material', 'category', 'color'];
        foreach ($filters_names as $filter_name) {
            $filters[$filter_name] = $request->get($filter_name, 0);
        }
        $colors     = $this->product_repository->getAvailableColors($filters);
        $items      = $this->product_repository->findFiltered($this->configs->get('products_limit', 49), $filters);
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::ATTRIBUTES => [
                'id',
                'price',
                'image',
                'name',
                'uri',
                'colorId',
                'colorName',
                'materialName',
                'discount',
            ],
        ]);
        $products   = json_decode($jsonObject);
        
        return new Response(json_encode(compact('products', 'colors')), 200, ['Content-Type' => 'application/json']);
    }
    
    private function getInitColors()
    {
        $items      = $this->color_repository->findAll();
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'hex'],
        ]);
        
        return json_decode($jsonObject);
    }
    
    private function getInitTypeData()
    {
        $items = $this->type_repository->findBy(['show_main_page_calc' => 1]);
        
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES         => ['products'],
        ]);
        
        return json_decode($jsonObject);
    }
    
    private function getInitCategories()
    {
        $items      = $this->category_repository->findAll();
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::ATTRIBUTES => ['id', 'name'],
        ]);
        
        return json_decode($jsonObject);
    }
}