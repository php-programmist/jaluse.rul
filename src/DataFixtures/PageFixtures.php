<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends Fixture
{
    /**
     * @var Connection
     */
    protected $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    public function load(ObjectManager $manager)
    {
        $old_content = $this->connection->createQueryBuilder()
                         ->select('id,pagetitle,longtitle,parent,introtext,content,uri,isfolder')
                         ->from('modx_site_content')
                         ->andWhere('id NOT IN(82,83,84,85,15,16,17)')
                         ->andWhere('parent NOT IN(82,83,84,85)')
                         ->orderBy('id')
                         ->execute()
                         ->fetchAll(\PDO::FETCH_OBJ);
        foreach ($old_content as $old_page) {
            $color = $this->connection->createQueryBuilder()
                ->select('value')
                ->from('modx_site_tmplvar_contentvalues')
                ->andWhere('contentid = '.$old_page->id)
                ->andWhere('tmplvarid = 24')
                ->execute()
                ->fetchColumn();
            $type = $this->connection->createQueryBuilder()
                ->select('value')
                ->from('modx_site_tmplvar_contentvalues')
                ->andWhere('contentid = '.$old_page->id)
                ->andWhere('tmplvarid = 25')
                ->execute()
                ->fetchColumn();
            $material = $this->connection->createQueryBuilder()
                ->select('value')
                ->from('modx_site_tmplvar_contentvalues')
                ->andWhere('contentid = '.$old_page->id)
                ->andWhere('tmplvarid = 27')
                ->execute()
                ->fetchColumn();
                
            $values = [
                'id'=>$old_page->id,
                'page_type'=> $this->connection->quote((!$old_page->isfolder&&$old_page->parent)||$color||$type||$material?'product':'catalog'),
                'name'=> $this->connection->quote($old_page->pagetitle),
                'uri'=> $this->connection->quote(trim($old_page->uri,'/')),
                'longtitle'=> $this->connection->quote($old_page->longtitle),
                'introtext'=> $this->connection->quote($old_page->introtext),
                'content'=>$this->connection->quote($old_page->content),
                'published'=>1,
                'modified_at'=> $this->connection->quote(date('Y-m-d H:i:s')),
                'created_at'=> $this->connection->quote(date('Y-m-d H:i:s')),
            ];
            if ($old_page->parent) {
                $values['parent_id'] = $old_page->parent;
            }
            if ($color) {
                if (strpos($color, '||') !== false) {
                    $color = strstr($color,'||',true);
                }
                $values['color_id'] = $color;
            }
            if ($type) {
                if (strpos($type, '||') !== false) {
                    $type = strstr($type,'||',true);
                }
                $values['type_id'] = $type;
            }
            if ($material) {
                if (strpos($material, '||') !== false) {
                    $material = strstr($material,'||',true);
                }
                $values['material_id'] = $material;
            }
            $query = $this->connection->createQueryBuilder()
                ->insert('page')
                ->values($values);
            $query->execute();
        }
    }
}
