<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ColorRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use App\Service\CalculationService;
use App\Service\ConfigService;
use App\Service\MatrixService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/calc", name="calc_")
 */
class CalcController extends AbstractController
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
    /**
     * @var MatrixService
     */
    protected $matrix_service;
    /**
     * @var AdapterInterface
     */
    protected $cache;
    /**
     * @var CalculationService
     */
    protected $calculation_service;
    
    public function __construct(
        ProductRepository $product_repository,
        TypeRepository $type_repository,
        SerializerInterface $serializer,
        ColorRepository $color_repository,
        CategoryRepository $category_repository,
        ConfigService $configs,
        MatrixService $matrix_service,
        CalculationService $calculation_service,
        AdapterInterface $cache
    ) {
        $this->product_repository  = $product_repository;
        $this->type_repository     = $type_repository;
        $this->serializer          = $serializer;
        $this->color_repository    = $color_repository;
        $this->category_repository = $category_repository;
        $this->configs             = $configs;
        $this->matrix_service      = $matrix_service;
        $this->cache               = $cache;
        $this->calculation_service = $calculation_service;
    }
    
    /**
     * @Route("/getInitData", name="init")
     */
    public function getInitData()
    {
        $item = $this->cache->getItem('calc.init_data');
        if (!$item->isHit()) {
            $types        = $this->getInitTypeData();
            $colors       = $this->getInitColors();
            $categories   = $this->getInitCategories();
            $matrices     = $this->matrix_service->getAllMatrices();
            $priceConfigs = $this->configs->getGroup('calc');
    
            $response = compact('types', 'colors', 'categories', 'priceConfigs', 'matrices');
            $response = json_encode($response);
            $item->set($response);
            $this->cache->save($item);
        }
        $response = $response ?? $item->get();
    
        return new Response($response, 200, ['Content-Type' => 'application/json']);
    }
    
    /**
     * @Route("/getProducts", name="get_products")
     */
    public function getInitProducts(Request $request, CalculationService $calculationService)
    {
        $filters       = [];
        $filters_names = ['type', 'material', 'category', 'color'];
        foreach ($filters_names as $filter_name) {
            $filters[$filter_name] = $request->get($filter_name, 0);
        }
        $colors = $this->product_repository->getAvailableColors($filters);
        $limit  = $this->configs->getCached('calc.products_limit');
        
        $items = $this->product_repository->findFiltered($filters, 0, $limit);
        $items = $calculationService->setRubPriceForProducts($items);
        
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::ATTRIBUTES => Product::SERIALIZER_ATTRIBUTES,
        ]);
        $products   = json_decode($jsonObject);
        
        return new JsonResponse(compact('products', 'colors'));
    }
    
    /**
     * @Route("/getCatalogProducts", name="get_catalog_products")
     */
    public function getCatalogProducts(Request $request, CalculationService $calculationService)
    {
        $filters       = [];
        $filters_names = ['type', 'material', 'category', 'color'];
        foreach ($filters_names as $filter_name) {
            $filters[$filter_name] = $request->query->get($filter_name, 0);
        }
        $page   = $request->query->get('page', 1);
        $limit  = $this->configs->getCached('calc.products_catalog_limit');
        $offset = $limit * ($page - 1);
        $colors = $this->product_repository->getAvailableColors($filters);
        
        $items = $this->product_repository->findFiltered($filters, $offset, $limit);
        $items = $calculationService->setRubPriceForProducts($items);
        
        $count = $this->product_repository->countFiltered($filters);
        $this->calculation_service->setMinPriceForAll($items);
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::ATTRIBUTES => Product::SERIALIZER_ATTRIBUTES,
        ]);
        $products   = json_decode($jsonObject);
        
        return new JsonResponse(compact('products', 'colors', 'count'));
    }
    
    /**
     * @Route("/getProduct/{id}", name="get_product")
     */
    public function getProduct(Product $product, CalculationService $calculationService): JsonResponse
    {
        $calculationService->setRubPriceForProduct($product);
        $jsonObject = $this->serializer->serialize($product, 'json', [
            AbstractNormalizer::ATTRIBUTES => Product::SERIALIZER_ATTRIBUTES,
        ]);
        
        return new JsonResponse($jsonObject, json: true);
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
        $items = $this->type_repository->findWithMaterials();
        
        $jsonObject = $this->serializer->serialize($items, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES                 => ['id', 'name', 'materials' => ['id', 'name']],
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