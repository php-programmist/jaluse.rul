<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528121920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем флаг каталога-агрегатор';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD aggregate_catalog TINYINT(1) DEFAULT \'0\'');
        $this->addSql('update page set aggregate_catalog = 1 where uri = ?', [
            'zhalyuzi-na-okna-pvh',
        ]);
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP aggregate_catalog');
    }
}
