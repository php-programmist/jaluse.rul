<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Удаляем товары';
    }
    
    public function up(Schema $schema): void
    {
        $uris = [
            'zhalyuzi/gorizontalnye/alyuminievye/445',
            'zhalyuzi/gorizontalnye/alyuminievye/1812',
            'zhalyuzi/gorizontalnye/alyuminievye/275',
        ];
        foreach ($uris as $uri) {
            $this->addSql('delete from page where uri = ?', [
                $uri,
            ]);
        }
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
