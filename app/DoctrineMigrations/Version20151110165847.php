<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151110165847 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_brand (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, city_id INT DEFAULT NULL, region_id INT DEFAULT NULL, image_id INT DEFAULT NULL, publish TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, h1 VARCHAR(255) NOT NULL, brief LONGTEXT DEFAULT NULL, full LONGTEXT NOT NULL, address VARCHAR(255) DEFAULT NULL, coords VARCHAR(255) DEFAULT NULL, person VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, date_add DATETIME NOT NULL, INDEX IDX_2B433462A76ED395 (user_id), INDEX IDX_2B4334628BAC62AF (city_id), INDEX IDX_2B43346298260155 (region_id), INDEX IDX_2B4334623DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_city (id INT AUTO_INCREMENT NOT NULL, sort_number INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_designer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, city_id INT DEFAULT NULL, region_id INT DEFAULT NULL, image_id INT DEFAULT NULL, publish TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, h1 VARCHAR(255) NOT NULL, brief LONGTEXT DEFAULT NULL, full LONGTEXT NOT NULL, address VARCHAR(255) DEFAULT NULL, coords VARCHAR(255) DEFAULT NULL, person VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, date_add DATETIME NOT NULL, INDEX IDX_8EB837DBA76ED395 (user_id), INDEX IDX_8EB837DB8BAC62AF (city_id), INDEX IDX_8EB837DB98260155 (region_id), INDEX IDX_8EB837DB3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_manufacturer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, city_id INT DEFAULT NULL, region_id INT DEFAULT NULL, image_id INT DEFAULT NULL, publish TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, h1 VARCHAR(255) NOT NULL, brief LONGTEXT DEFAULT NULL, full LONGTEXT NOT NULL, address VARCHAR(255) DEFAULT NULL, coords VARCHAR(255) DEFAULT NULL, person VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, date_add DATETIME NOT NULL, INDEX IDX_AC136F80A76ED395 (user_id), INDEX IDX_AC136F808BAC62AF (city_id), INDEX IDX_AC136F8098260155 (region_id), INDEX IDX_AC136F803DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_news (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, publish TINYINT(1) DEFAULT NULL, on_main TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, h1 VARCHAR(255) NOT NULL, brief LONGTEXT NOT NULL, full LONGTEXT NOT NULL, foto_from VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, INDEX IDX_D42553BB3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_region (id INT AUTO_INCREMENT NOT NULL, sort_number INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_brand ADD CONSTRAINT FK_2B433462A76ED395 FOREIGN KEY (user_id) REFERENCES sip_user_user (id)');
        $this->addSql('ALTER TABLE sip_brand ADD CONSTRAINT FK_2B4334628BAC62AF FOREIGN KEY (city_id) REFERENCES sip_city (id)');
        $this->addSql('ALTER TABLE sip_brand ADD CONSTRAINT FK_2B43346298260155 FOREIGN KEY (region_id) REFERENCES sip_region (id)');
        $this->addSql('ALTER TABLE sip_brand ADD CONSTRAINT FK_2B4334623DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('ALTER TABLE sip_designer ADD CONSTRAINT FK_8EB837DBA76ED395 FOREIGN KEY (user_id) REFERENCES sip_user_user (id)');
        $this->addSql('ALTER TABLE sip_designer ADD CONSTRAINT FK_8EB837DB8BAC62AF FOREIGN KEY (city_id) REFERENCES sip_city (id)');
        $this->addSql('ALTER TABLE sip_designer ADD CONSTRAINT FK_8EB837DB98260155 FOREIGN KEY (region_id) REFERENCES sip_region (id)');
        $this->addSql('ALTER TABLE sip_designer ADD CONSTRAINT FK_8EB837DB3DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('ALTER TABLE sip_manufacturer ADD CONSTRAINT FK_AC136F80A76ED395 FOREIGN KEY (user_id) REFERENCES sip_user_user (id)');
        $this->addSql('ALTER TABLE sip_manufacturer ADD CONSTRAINT FK_AC136F808BAC62AF FOREIGN KEY (city_id) REFERENCES sip_city (id)');
        $this->addSql('ALTER TABLE sip_manufacturer ADD CONSTRAINT FK_AC136F8098260155 FOREIGN KEY (region_id) REFERENCES sip_region (id)');
        $this->addSql('ALTER TABLE sip_manufacturer ADD CONSTRAINT FK_AC136F803DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id)');
        $this->addSql('ALTER TABLE sip_news ADD CONSTRAINT FK_D42553BB3DA5256D FOREIGN KEY (image_id) REFERENCES sip_media_gallery_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_brand DROP FOREIGN KEY FK_2B4334628BAC62AF');
        $this->addSql('ALTER TABLE sip_designer DROP FOREIGN KEY FK_8EB837DB8BAC62AF');
        $this->addSql('ALTER TABLE sip_manufacturer DROP FOREIGN KEY FK_AC136F808BAC62AF');
        $this->addSql('ALTER TABLE sip_brand DROP FOREIGN KEY FK_2B43346298260155');
        $this->addSql('ALTER TABLE sip_designer DROP FOREIGN KEY FK_8EB837DB98260155');
        $this->addSql('ALTER TABLE sip_manufacturer DROP FOREIGN KEY FK_AC136F8098260155');
        $this->addSql('DROP TABLE sip_brand');
        $this->addSql('DROP TABLE sip_city');
        $this->addSql('DROP TABLE sip_designer');
        $this->addSql('DROP TABLE sip_manufacturer');
        $this->addSql('DROP TABLE sip_news');
        $this->addSql('DROP TABLE sip_region');
    }
}
