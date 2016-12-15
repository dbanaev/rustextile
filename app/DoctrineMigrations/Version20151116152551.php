<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151116152551 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE designer_brand (designer_id INT NOT NULL, brand_id INT NOT NULL, INDEX IDX_4C957584CFC54FAB (designer_id), INDEX IDX_4C95758444F5D008 (brand_id), PRIMARY KEY(designer_id, brand_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE designer_brand ADD CONSTRAINT FK_4C957584CFC54FAB FOREIGN KEY (designer_id) REFERENCES sip_designer (id)');
        $this->addSql('ALTER TABLE designer_brand ADD CONSTRAINT FK_4C95758444F5D008 FOREIGN KEY (brand_id) REFERENCES sip_brand (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE designer_brand');
    }
}
