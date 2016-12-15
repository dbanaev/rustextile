<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151111235818 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_main_spot (id INT AUTO_INCREMENT NOT NULL, image_id_1 INT DEFAULT NULL, image_id_2 INT DEFAULT NULL, image_id_3 INT DEFAULT NULL, title_1 VARCHAR(255) NOT NULL, link_item_1 VARCHAR(255) NOT NULL, link_list_1 VARCHAR(255) NOT NULL, title_2 VARCHAR(255) NOT NULL, link_item_2 VARCHAR(255) NOT NULL, link_list_2 VARCHAR(255) NOT NULL, title_3 VARCHAR(255) NOT NULL, link_item_3 VARCHAR(255) NOT NULL, link_list_3 VARCHAR(255) NOT NULL, INDEX IDX_B404D3D8B673AF56 (image_id_1), INDEX IDX_B404D3D82F7AFEEC (image_id_2), INDEX IDX_B404D3D8587DCE7A (image_id_3), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_main_spot ADD CONSTRAINT FK_B404D3D8B673AF56 FOREIGN KEY (image_id_1) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('ALTER TABLE sip_main_spot ADD CONSTRAINT FK_B404D3D82F7AFEEC FOREIGN KEY (image_id_2) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('ALTER TABLE sip_main_spot ADD CONSTRAINT FK_B404D3D8587DCE7A FOREIGN KEY (image_id_3) REFERENCES sip_media_gallery_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sip_main_spot');
    }
}
