<?php

namespace App\Controller\Admin;

use App\Repository\CatalogRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Connection;
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
    
    public function __construct(Connection $connection,ParameterBagInterface $params,ProductRepository $product_repository,CatalogRepository $catalog_repository, CategoryRepository $category_repository)
    {
        
        $this->connection = $connection;
        $this->params = $params;
        $this->product_repository = $product_repository;
        $this->catalog_repository = $catalog_repository;
        $this->category_repository = $category_repository;
    }
    /**
     * @Route("/mini", name="mini")
     */
    public function mini()
    {
        $project_dir = $this->params->get('kernel.project_dir');
        $fh = fopen($project_dir.'/csv/mini.csv','r');
        $entityManager = $this->getDoctrine()->getManager();
        $parent = $this->catalog_repository->find(2801);
        $counter = 0;
        while ($row = fgetcsv($fh,8000,';')){
            [$uri,$matrix_id,$category] = $row;
            $product = $this->product_repository->findOneBy(['uri'=>$uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:'.$uri);
            }
            $category = $this->category_repository->find($category);
            $copy_product = clone $product;
            $copy_product->setParent($parent);
            $copy_product->setMatrixId($matrix_id);
            $copy_product->setCategory($category);
            $copy_product->setUri(str_replace('kollekcziya-euro-vista-novinka-sezona-2014','mini',$uri));
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
        $project_dir = $this->params->get('kernel.project_dir');
        $fh = fopen($project_dir.'/csv/uni.csv','r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter = 0;
        while ($row = fgetcsv($fh,8000,';')){
            [$uri,$matrix_id,$category] = $row;
            $product = $this->product_repository->findOneBy(['uri'=>$uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:'.$uri);
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
        $project_dir = $this->params->get('kernel.project_dir');
        $fh = fopen($project_dir.'/csv/combo-uni.csv','r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter = 0;
        while ($row = fgetcsv($fh,8000,';')){
            [$uri,$matrix_id,$category] = $row;
            $product = $this->product_repository->findOneBy(['uri'=>$uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:'.$uri);
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
        $project_dir = $this->params->get('kernel.project_dir');
        $fh = fopen($project_dir.'/csv/combo-small.csv','r');
        $entityManager = $this->getDoctrine()->getManager();
        $counter = 0;
        while ($row = fgetcsv($fh,8000,';')){
            [$uri,$matrix_id,$category] = $row;
            $product = $this->product_repository->findOneBy(['uri'=>$uri]);
            if ( ! $product) {
                throw new \Exception('не найден товар:'.$uri);
            }
            $category = $this->category_repository->find($category);
            $product->setMatrixId($matrix_id);
            $product->setCategory($category);
            $counter++;
        }
        $entityManager->flush();
        return new Response($counter);
    }
}
