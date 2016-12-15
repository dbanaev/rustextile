<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151119181935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_event ADD flickr_galley_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_news ADD flickr_galley_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_publishing ADD flickr_galley_id VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_event DROP flickr_galley_id');
        $this->addSql('ALTER TABLE sip_news DROP flickr_galley_id');
        $this->addSql('ALTER TABLE sip_publishing DROP flickr_galley_id');
    }
}
