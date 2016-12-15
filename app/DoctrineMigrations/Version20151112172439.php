<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151112172439 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_main_spot CHANGE title_1 title_1 VARCHAR(255) DEFAULT NULL, CHANGE link_item_1 link_item_1 VARCHAR(255) DEFAULT NULL, CHANGE link_list_1 link_list_1 VARCHAR(255) DEFAULT NULL, CHANGE title_2 title_2 VARCHAR(255) DEFAULT NULL, CHANGE link_item_2 link_item_2 VARCHAR(255) DEFAULT NULL, CHANGE link_list_2 link_list_2 VARCHAR(255) DEFAULT NULL, CHANGE title_3 title_3 VARCHAR(255) DEFAULT NULL, CHANGE link_item_3 link_item_3 VARCHAR(255) DEFAULT NULL, CHANGE link_list_3 link_list_3 VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_main_spot CHANGE title_1 title_1 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE link_item_1 link_item_1 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE link_list_1 link_list_1 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE title_2 title_2 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE link_item_2 link_item_2 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE link_list_2 link_list_2 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE title_3 title_3 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE link_item_3 link_item_3 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE link_list_3 link_list_3 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
