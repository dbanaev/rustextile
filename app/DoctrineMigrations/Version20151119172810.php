<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151119172810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_brand_has_media (id INT AUTO_INCREMENT NOT NULL, designer_id INT DEFAULT NULL, image_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_105EFD54CFC54FAB (designer_id), INDEX IDX_105EFD543DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_manufacturer_has_media (id INT AUTO_INCREMENT NOT NULL, manufacturer_id INT DEFAULT NULL, image_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_CBD9D809A23B42D (manufacturer_id), INDEX IDX_CBD9D8093DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_brand_has_media ADD CONSTRAINT FK_105EFD54CFC54FAB FOREIGN KEY (designer_id) REFERENCES sip_brand (id)');
        $this->addSql('ALTER TABLE sip_brand_has_media ADD CONSTRAINT FK_105EFD543DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sip_manufacturer_has_media ADD CONSTRAINT FK_CBD9D809A23B42D FOREIGN KEY (manufacturer_id) REFERENCES sip_manufacturer (id)');
        $this->addSql('ALTER TABLE sip_manufacturer_has_media ADD CONSTRAINT FK_CBD9D8093DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sip_brand_has_media');
        $this->addSql('DROP TABLE sip_manufacturer_has_media');
    }
}
