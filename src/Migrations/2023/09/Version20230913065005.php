<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913065005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем редиректы';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('update subdomain set redirects = ? where name = ?', [
            json_encode(['/moskovskoy-oblasti/v-lyubercah/']),
            'lyubercy',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
