<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411052954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');
        
        $uris = [
            'zhalyuzi',
            'zhalyuzi/vertikalnye',
            'zhalyuzi/gorizontalnye',
            'zhalyuzi/plisse',
            'zhalyuzi/vertikalnye/tkanevye',
            'zhalyuzi/vertikalnye/plastikovyie',
            'zhalyuzi/gorizontalnye/alyuminievye',
            'zhalyuzi/gorizontalnye/derevyannye',
            'rulonnyie-shtoryi',
            'rulonnyie-shtoryi/mini',
            'rulonnyie-shtoryi/uni',
            'rulonnyie-shtoryi/den-noch-uni-2',
            'rulonnyie-shtoryi/standartnye-rulonnye-shtory',
        ];
        $in   = substr(str_repeat('?,', count($uris)), 0, -1);
        $this->addSql('ALTER TABLE page ADD show_seo_text TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql("UPDATE page SET show_seo_text = 0 where uri in($in)", $uris);
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE page DROP show_seo_text');
    }
}
