<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428170002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Удаляем поля premium и no_drill';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE page DROP no_drill');
        $this->addSql('ALTER TABLE page DROP premium');
    }
    
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE page ADD no_drill TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE page ADD premium TINYINT(1) DEFAULT \'0\'');
    }
}
