<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151112183612 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_designer_has_media (id INT AUTO_INCREMENT NOT NULL, designer_id INT DEFAULT NULL, image_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_ECA295B7CFC54FAB (designer_id), INDEX IDX_ECA295B73DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_designer_has_media ADD CONSTRAINT FK_ECA295B7CFC54FAB FOREIGN KEY (designer_id) REFERENCES sip_designer (id)');
        $this->addSql('ALTER TABLE sip_designer_has_media ADD CONSTRAINT FK_ECA295B73DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sip_designer_has_media');
    }
}
