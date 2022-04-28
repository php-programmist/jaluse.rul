<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\Catalog;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428170001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем заполняем SEO-тип';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE page SET seo_type = ? where premium = 1', [
            Catalog::SEO_TYPE_PREMIUM,
        ]);
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE page SET seo_type = ? where no_drill = 1', [
            Catalog::SEO_TYPE_NO_DRILL,
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
