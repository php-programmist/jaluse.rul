<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230904140511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем настройки поддоменов';
    }
    
    /**
     * @throws \JsonException
     */
    public function up(Schema $schema): void
    {
        $this->addSql('insert into subdomain (name, substitutions) values (?, ?)', [
            '',
            json_encode([
                '$city_prepositional'            => 'Москве',
                '$city_and_region_prepositional' => 'Москве и Московской области',
                '$city_genitive'                 => 'Москвы',
            ], JSON_THROW_ON_ERROR),
        ]);
        
        $this->addSql('insert into subdomain (name, substitutions) values (?, ?)', [
            'lyubercy',
            json_encode([
                '$city_prepositional'            => 'Люберцах',
                '$city_and_region_prepositional' => 'Люберцах',
                '$city_genitive'                 => 'Люберец',
            ], JSON_THROW_ON_ERROR),
        ]);
    }
    
    public function down(Schema $schema): void
    {
        $this->addSql('truncate table subdomain');
    }
}
