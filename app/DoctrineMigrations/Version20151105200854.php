<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151105200854 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE content_classification_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, context INT DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C52BCF7727ACA70 (parent_id), INDEX IDX_C52BCF7E25D857E (context), INDEX IDX_C52BCF7EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_classification_collection (id INT AUTO_INCREMENT NOT NULL, context INT DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D3EDA93EE25D857E (context), INDEX IDX_D3EDA93EEA9FDD75 (media_id), UNIQUE INDEX tag_collection (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_classification_context (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_classification_tag (id INT AUTO_INCREMENT NOT NULL, context INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_94FAD39E25D857E (context), UNIQUE INDEX tag_context (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_classification_category ADD CONSTRAINT FK_C52BCF7727ACA70 FOREIGN KEY (parent_id) REFERENCES content_classification_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_classification_category ADD CONSTRAINT FK_C52BCF7E25D857E FOREIGN KEY (context) REFERENCES content_classification_context (id)');
        $this->addSql('ALTER TABLE content_classification_category ADD CONSTRAINT FK_C52BCF7EA9FDD75 FOREIGN KEY (media_id) REFERENCES sip_media_gallery_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_classification_collection ADD CONSTRAINT FK_D3EDA93EE25D857E FOREIGN KEY (context) REFERENCES content_classification_context (id)');
        $this->addSql('ALTER TABLE content_classification_collection ADD CONSTRAINT FK_D3EDA93EEA9FDD75 FOREIGN KEY (media_id) REFERENCES sip_media_gallery_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_classification_tag ADD CONSTRAINT FK_94FAD39E25D857E FOREIGN KEY (context) REFERENCES content_classification_context (id)');
        $this->addSql('ALTER TABLE sip_media_gallery_has_media ADD gallery_id INT DEFAULT NULL, ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_media_gallery_has_media ADD CONSTRAINT FK_102716F24E7AF8F FOREIGN KEY (gallery_id) REFERENCES sip_media_gallery (id)');
        $this->addSql('ALTER TABLE sip_media_gallery_has_media ADD CONSTRAINT FK_102716F2EA9FDD75 FOREIGN KEY (media_id) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('CREATE INDEX IDX_102716F24E7AF8F ON sip_media_gallery_has_media (gallery_id)');
        $this->addSql('CREATE INDEX IDX_102716F2EA9FDD75 ON sip_media_gallery_has_media (media_id)');
        $this->addSql('ALTER TABLE sip_media_gallery_media ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_media_gallery_media ADD CONSTRAINT FK_DF10FA6F12469DE2 FOREIGN KEY (category_id) REFERENCES content_classification_category (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_DF10FA6F12469DE2 ON sip_media_gallery_media (category_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE content_classification_category DROP FOREIGN KEY FK_C52BCF7727ACA70');
        $this->addSql('ALTER TABLE sip_media_gallery_media DROP FOREIGN KEY FK_DF10FA6F12469DE2');
        $this->addSql('ALTER TABLE content_classification_category DROP FOREIGN KEY FK_C52BCF7E25D857E');
        $this->addSql('ALTER TABLE content_classification_collection DROP FOREIGN KEY FK_D3EDA93EE25D857E');
        $this->addSql('ALTER TABLE content_classification_tag DROP FOREIGN KEY FK_94FAD39E25D857E');
        $this->addSql('DROP TABLE content_classification_category');
        $this->addSql('DROP TABLE content_classification_collection');
        $this->addSql('DROP TABLE content_classification_context');
        $this->addSql('DROP TABLE content_classification_tag');
        $this->addSql('ALTER TABLE sip_media_gallery_has_media DROP FOREIGN KEY FK_102716F24E7AF8F');
        $this->addSql('ALTER TABLE sip_media_gallery_has_media DROP FOREIGN KEY FK_102716F2EA9FDD75');
        $this->addSql('DROP INDEX IDX_102716F24E7AF8F ON sip_media_gallery_has_media');
        $this->addSql('DROP INDEX IDX_102716F2EA9FDD75 ON sip_media_gallery_has_media');
        $this->addSql('ALTER TABLE sip_media_gallery_has_media DROP gallery_id, DROP media_id');
        $this->addSql('DROP INDEX IDX_DF10FA6F12469DE2 ON sip_media_gallery_media');
        $this->addSql('ALTER TABLE sip_media_gallery_media DROP category_id');
    }
}
