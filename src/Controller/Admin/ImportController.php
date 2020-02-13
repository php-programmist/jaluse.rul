<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\CatalogRepository;
use App\Repository\CategoryRepository;
use App\Repository\MaterialRepository;
use App\Repository\ProductRepository;
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
}
