<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Entity\Markiz;
use App\Entity\Product;
use App\Entity\Roll;
use App\Repository\CatalogRepository;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Repository\MarkizRepository;
use App\Repository\MaterialRepository;
use App\Repository\ProductRepository;
use App\Repository\RollRepository;
use App\Repository\RomanRepository;
use App\Repository\TypeRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/import", name="admin_import_")
 */
class ImportController extends AbstractController
{
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * @var ParameterBagInterface
     */
    protected $params;
    /**
     * @var ProductRepository
     */
    protected $product_repository;
    /**
     * @var CatalogRepository
     */
    protected $catalog_repository;
    /**
     * @var CategoryRepository
     */
    protected $category_repository;
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    
    public function __construct(
        Connection $connection,
        ParameterBagInterface $params,
        ProductRepository $product_repository,
        CatalogRepository $catalog_repository,
        CategoryRepository $category_repository,
        EntityManagerInterface $em
    ) {
        
        $this->connection          = $connection;
        $this->params              = $params;
        $this->product_repository  = $product_repository;
        $this->catalog_repository  = $catalog_repository;
        $this->category_repository = $category_repository;
        $this->em                  = $em;
    }
    
    /**
     * @Route("/mini", name="mini")
     */
    public function mini()
    {
        $project_dir   = $this->params->get('kernel.project_dir');
        $fh            = fopen($project_dir . '/csv/mini.csv', 'r');
        $entityManager = $this->getDoctrine()->getManager();
        $parent        = $this->catalog_repository->find(2801);
        $counter       = 0;
        while ($row = fgetcsv($fh, 8000, ';')) {
            [$uri, $matrix_id, $category] = $row;
            $product = $this->product_repository->findOneBy(['uri' => $uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:' . $uri);
            }
            $category     = $this->category_repository->find($category);
            $copy_product = clone $product;
            $copy_product->setParent($parent);
            $copy_product->setMatrixId($matrix_id);
            $copy_product->setCategory($category);
            $copy_product->setUri(str_replace('kollekcziya-euro-vista-novinka-sezona-2014', 'mini', $uri));
            $entityManager->persist($copy_product);
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/uni", name="uni")
     */
    public function uni()
    {
        $project_dir   = $this->params->get('kernel.project_dir');
        $fh            = fopen($project_dir . '/csv/uni.csv', 'r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter       = 0;
        while ($row = fgetcsv($fh, 8000, ';')) {
            [$uri, $matrix_id, $category] = $row;
            $product = $this->product_repository->findOneBy(['uri' => $uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:' . $uri);
            }
            $category = $this->category_repository->find($category);
            $product->setMatrixId($matrix_id);
            $product->setCategory($category);
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/combo_uni", name="combo_uni")
     */
    public function combo_uni()
    {
        $project_dir   = $this->params->get('kernel.project_dir');
        $fh            = fopen($project_dir . '/csv/combo-uni.csv', 'r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter       = 0;
        while ($row = fgetcsv($fh, 8000, ';')) {
            [$uri, $matrix_id, $category] = $row;
            $product = $this->product_repository->findOneBy(['uri' => $uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:' . $uri);
            }
            $category = $this->category_repository->find($category);
            $product->setMatrixId($matrix_id);
            $product->setCategory($category);
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/combo_small", name="combo_small")
     */
    public function combo_small()
    {
        $project_dir   = $this->params->get('kernel.project_dir');
        $fh            = fopen($project_dir . '/csv/combo-small.csv', 'r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter       = 0;
        while ($row = fgetcsv($fh, 8000, ';')) {
            [$uri, $matrix_id, $category] = $row;
            $product = $this->product_repository->findOneBy(['uri' => $uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:' . $uri);
            }
            $category = $this->category_repository->find($category);
            $product->setMatrixId($matrix_id);
            $product->setCategory($category);
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/standart", name="standart")
     */
    public function standart()
    {
        $project_dir   = $this->params->get('kernel.project_dir');
        $fh            = fopen($project_dir . '/csv/standart.csv', 'r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter       = 0;
        while ($row = fgetcsv($fh, 8000, ';')) {
            [$uri, $matrix_id, $category] = $row;
            $product = $this->product_repository->findOneBy(['uri' => $uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:' . $uri);
            }
            $category = $this->category_repository->find($category);
            $product->setMatrixId($matrix_id);
            $product->setCategory($category);
            $product->setUri(str_replace('kollekcziya-euro-vista-novinka-sezona-2014', 'standartnye-rulonnye-shtory',
                $uri));
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/sub_types", name="sub_types")
     */
    public function sub_types(TypeRepository $type_repository, MaterialRepository $material_repository)
    {
        $type          = $type_repository->find(133);
        $sub_types_map = [
            191 => 'combo-small',
            192 => 'combo-uni',
            193 => 'mini',
            194 => 'uni',
            195 => 'standart',
        ];
        foreach ($sub_types_map as $id => $matrix_folder) {
            $material = $material_repository->find($id);
            $catalog  = $this->catalog_repository->findOneBy(['matrix_folder' => $matrix_folder]);
            foreach ($catalog->getPages() as $page) {
                if ($page instanceof Product) {
                    $page->setMaterial($material);
                    $page->setType($type);
                }
            }
        }
        $this->getDoctrine()->getManager()->flush();
    }
    
    /**
     * @Route("/change_names", name="change_names")
     */
    public function change_names()
    {
        $catalog_id = 30;
        $catalog    = $this->catalog_repository->find($catalog_id);
        $counter = 0;
        foreach ($catalog->getPages() as $page) {
            if ($page instanceof Product) {
                $old_name = $page->getName();
                if (stripos($old_name, 'Рулонные шторы') !== false) {
                    $new_name = str_replace('Рулонные шторы','Стандартные рулонные шторы',$page->getName());
                }else{
                    $new_name = 'Стандартные рулонные шторы '.$page->getName();
                }
                
                $page->setName($new_name);
                $counter++;
            }
            
        }
        $this->em->flush();
        return new Response($counter);
    }
    
    /**
     * @Route("/locations", name="locations")
     */
    public function locations(LocationRepository $location_repository)
    {
        $root_dir   = $_SERVER['DOCUMENT_ROOT'];
        $entityManager = $this->getDoctrine()->getManager();
        $locations        = $location_repository->findAll();
        $counter       = 0;
        /** @var Location $location */
        foreach ($locations as $location) {
            $description = $this->getExtrafield($location->getId(),73);
            $location->setLocationDescription($description);
    
            $image = $this->getExtrafield($location->getId(),68);
            if ($image) {
                $image_file = file_get_contents('https://jaluse.ru/assets/images/'.$image);
                $image = str_replace('/','-',$image);
                $location->setLocationImage($image);
                file_put_contents($root_dir.'/img/location/'.$image,$image_file);
            }
            
    
            $title = $this->getExtrafield($location->getId(),1);
            $location->setTitle($title);
            
            $description = $this->getExtrafield($location->getId(),4);
            $location->setDescription($description);
    
            $content = $this->getContent($location->getId());
            $location->setContent($content->content);
            if ($content->longtitle) {
                $location->setName($content->longtitle);
            }else{
                $location->setName($content->pagetitle);
            }
            
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/markiz", name="markiz")
     */
    public function markiz(MarkizRepository $markiz_repository)
    {
        $root_dir   = $_SERVER['DOCUMENT_ROOT'];
        $entityManager = $this->getDoctrine()->getManager();
        $markizs        = $markiz_repository->findAll();
        $counter       = 0;
        /** @var Markiz $markiz */
        foreach ($markizs as $markiz) {
            $description = $this->getExtrafield($markiz->getId(),73);
            $markiz->setCardDescription($description);
            $image = $this->getExtrafield($markiz->getId(),68);
            if ($image) {
                $image_file = file_get_contents('https://jaluse.ru/assets/images/'.$image);
                $image = str_replace('/','-',$image);
                $markiz->setCardImage($image);
                file_put_contents($root_dir.'/img/markiz/'.$image,$image_file);
            }
    
            $our_works_folder = $this->getExtrafield($markiz->getId(),69);
            $our_works_folder = trim($our_works_folder,' /');
            $parts = explode('/',$our_works_folder);
            $alias = array_pop($parts);
            $markiz->setOurWorksFolder('/img/our-works/markiz/'.$alias);
            
            $price = $this->getExtrafield($markiz->getId(),20);
            $markiz->setPrice($price);
            
            $title = $this->getExtrafield($markiz->getId(),1);
            $markiz->setTitle($title);
            
            $description = $this->getExtrafield($markiz->getId(),4);
            $markiz->setDescription(str_replace('[[*price_from_cat]]',$price,$description));
    
            $content = $this->getContent($markiz->getId());
            $markiz->setContent($content->content);
            if ($content->longtitle) {
                $markiz->setName($content->longtitle);
            }else{
                $markiz->setName($content->pagetitle);
            }
            
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/roll", name="roll")
     */
    public function roll(RollRepository $repository)
    {
        $root_dir   = $_SERVER['DOCUMENT_ROOT'];
        $entityManager = $this->getDoctrine()->getManager();
        $items        = $repository->findAll();
        $counter       = 0;
        /** @var Roll $item */
        foreach ($items as $item) {
            $description = $this->getExtrafield($item->getId(),67);
            $item->setCardDescription($description);
            $image = $this->getExtrafield($item->getId(),68);
            if ($image) {
                $image_file = file_get_contents('https://jaluse.ru/assets/images/'.$image);
                $image = str_replace('/','-',$image);
                $item->setCardImage($image);
                file_put_contents($root_dir.'/img/roll/'.$image,$image_file);
            }
    
            $our_works_folder = $this->getExtrafield($item->getId(),69);
            $our_works_folder = trim($our_works_folder,' /');
            $parts = explode('/',$our_works_folder);
            $alias = array_pop($parts);
            $item->setOurWorksFolder('/img/our-works/roll/'.$alias);
            
            $price = $this->getExtrafield($item->getId(),20);
            $item->setPrice($price);
            
            $title = $this->getExtrafield($item->getId(),1);
            $item->setTitle($title);
            
            $description = $this->getExtrafield($item->getId(),4);
            $item->setDescription(str_replace('[[*price_from_cat]]',$price,$description));
    
            $content = $this->getContent($item->getId());
            $item->setContent($content->content);
            if (!$content->content) {
                $item->setContent($this->getExtrafield($item->getId(),15));
            }
            if ($content->longtitle) {
                $item->setName($content->longtitle);
            }else{
                $item->setName($content->pagetitle);
            }
            
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    /**
     * @Route("/roman", name="roman")
     */
    public function roman(RomanRepository $repository)
    {
        $root_dir   = $_SERVER['DOCUMENT_ROOT'];
        $entityManager = $this->getDoctrine()->getManager();
        $items        = $repository->findAll();
        $counter       = 0;
        /** @var Roll $item */
        foreach ($items as $item) {
            // $description = $this->getExtrafield($item->getId(),67);
            // $item->setCardDescription($description);
            /*$image = $this->getExtrafield($item->getId(),68);
            if ($image) {
                $image_file = file_get_contents('https://jaluse.ru/assets/images/'.$image);
                $image = str_replace('/','-',$image);
                $item->setCardImage($image);
                file_put_contents($root_dir.'/img/roll/'.$image,$image_file);
            }*/
    
            /*$our_works_folder = $this->getExtrafield($item->getId(),69);
            $our_works_folder = trim($our_works_folder,' /');
            $parts = explode('/',$our_works_folder);
            $alias = array_pop($parts);
            $item->setOurWorksFolder('/img/our-works/roll/'.$alias);*/
            
            $price = $this->getExtrafield($item->getId(),20);
            $item->setPrice($price);
            
            $title = $this->getExtrafield($item->getId(),1);
            $item->setTitle($title);
            
            $description = $this->getExtrafield($item->getId(),4);
            $item->setDescription($description);
    
            $content = $this->getContent($item->getId());
            $item->setContent($content->content);
            if (!$content->content) {
                $item->setContent($this->getExtrafield($item->getId(),15));
            }
            
            $item->setName($content->pagetitle);
            
            $product = $this->getProduct($item->getId());
            if ($product) {
                $item->setPrice($product->price*62.5);
                $image = $product->image;
                if ($image) {
                    $image_file = file_get_contents('https://jaluse.ru'.$image);
                    $parts = explode('/',$image);
                    $image = array_pop($parts);
                    $item->setCardImage($image);
                    file_put_contents($root_dir.'/img/roman/'.$image,$image_file);
                }
            }
            
            $counter++;
        }
        $entityManager->flush();
        
        return new Response($counter);
    }
    
    private function getExtrafield($content_id, $var_id)
    {
        return $this->connection->createQueryBuilder()
                                  ->select('value')
                                  ->from('modx_site_tmplvar_contentvalues')
                                  ->andWhere('contentid='.$content_id)
                                  ->andWhere('tmplvarid='.$var_id)
                                  ->execute()
                                  ->fetchColumn();
    }
    
    private function getContent($content_id){
        return $this->connection->createQueryBuilder()
                                    ->select('*')
                                    ->from('modx_site_content')
                                    ->andWhere('id='.$content_id)
                                    ->execute()
                                    ->fetch(\PDO::FETCH_OBJ);
    }
    
    private function getProduct($content_id){
        return $this->connection->createQueryBuilder()
                                    ->select('*')
                                    ->from('modx_ms2_products')
                                    ->andWhere('id='.$content_id)
                                    ->execute()
                                    ->fetch(\PDO::FETCH_OBJ);
    }
}
