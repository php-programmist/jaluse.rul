<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210130093410 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page ADD turbo TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql("
                update page set turbo = 1 where uri in('zhalyuzi',
                'zhalyuzi/vertikalnye',
                'zhalyuzi/gorizontalnye',
                'zhalyuzi',
                'zhalyuzi/vertikalnye/tkanevye',
                'zhalyuzi/vertikalnye/plastikovyie',
                'zhalyuzi/gorizontalnye/alyuminievye',
                'zhalyuzi/gorizontalnye/derevyannye',
                'zhalyuzi/isolite',
                'rulonnyie-shtoryi',
                'rulonnyie-shtoryi/mini',
                'rulonnyie-shtoryi/uni',
                'rulonnyie-shtoryi/den-noch-uni-2',
                'rulonnyie-shtoryi/standartnye-rulonnye-shtory',
                'zhalyuzi/plisse',
                'rolstavni')
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP turbo');
    }
}
