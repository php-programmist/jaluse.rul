<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914072613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('update subdomain set city_nominative = ? where name = ?', [
            'Люберцы',
            'lyubercy',
        ]);
        $this->addSql('update subdomain set city_nominative = ? where name = ?', [
            'Москва',
            '',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    }
}
