<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151116174051 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_publishing (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, image_id INT DEFAULT NULL, publish TINYINT(1) DEFAULT NULL, on_main TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, h1 VARCHAR(255) NOT NULL, brief LONGTEXT NOT NULL, full LONGTEXT NOT NULL, foto_from VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, INDEX IDX_93CF4CB0C54C8C93 (type_id), INDEX IDX_93CF4CB03DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_publishing_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_publishing ADD CONSTRAINT FK_93CF4CB0C54C8C93 FOREIGN KEY (type_id) REFERENCES sip_publishing_type (id)');
        $this->addSql('ALTER TABLE sip_publishing ADD CONSTRAINT FK_93CF4CB03DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_publishing DROP FOREIGN KEY FK_93CF4CB0C54C8C93');
        $this->addSql('DROP TABLE sip_publishing');
        $this->addSql('DROP TABLE sip_publishing_type');
    }
}
