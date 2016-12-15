<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151106215033 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_event (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, h1 VARCHAR(255) NOT NULL, brief VARCHAR(255) DEFAULT NULL, full VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, foto_from VARCHAR(255) DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, INDEX IDX_CBFC79D3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_tag_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C22B7AE45E237E06 (name), UNIQUE INDEX UNIQ_C22B7AE4989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_tag_tagging (id INT AUTO_INCREMENT NOT NULL, tag_id INT DEFAULT NULL, resource_type VARCHAR(50) NOT NULL, resource_id VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EB7A37C7BAD26311 (tag_id), UNIQUE INDEX tagging_idx (tag_id, resource_type, resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_event ADD CONSTRAINT FK_CBFC79D3DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('ALTER TABLE sip_tag_tagging ADD CONSTRAINT FK_EB7A37C7BAD26311 FOREIGN KEY (tag_id) REFERENCES sip_tag_tag (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_tag_tagging DROP FOREIGN KEY FK_EB7A37C7BAD26311');
        $this->addSql('DROP TABLE sip_event');
        $this->addSql('DROP TABLE sip_tag_tag');
        $this->addSql('DROP TABLE sip_tag_tagging');
    }
}
