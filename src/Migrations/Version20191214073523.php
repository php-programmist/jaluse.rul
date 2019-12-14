<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191214073523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6207ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('CREATE INDEX IDX_140AB6207ADA1FB5 ON page (color_id)');
        $this->addSql('CREATE INDEX IDX_140AB620C54C8C93 ON page (type_id)');
        $this->addSql('CREATE INDEX IDX_140AB620E308AC6F ON page (material_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6207ADA1FB5');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620C54C8C93');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620E308AC6F');
        $this->addSql('DROP INDEX IDX_140AB6207ADA1FB5 ON page');
        $this->addSql('DROP INDEX IDX_140AB620C54C8C93 ON page');
        $this->addSql('DROP INDEX IDX_140AB620E308AC6F ON page');
    }
}
