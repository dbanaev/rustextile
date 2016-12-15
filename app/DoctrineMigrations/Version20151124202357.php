<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151124202357 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_manuf_rubric (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_manufacturer ADD rubric_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_manufacturer ADD CONSTRAINT FK_AC136F80A29EC0FC FOREIGN KEY (rubric_id) REFERENCES sip_manuf_rubric (id)');
        $this->addSql('CREATE INDEX IDX_AC136F80A29EC0FC ON sip_manufacturer (rubric_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_manufacturer DROP FOREIGN KEY FK_AC136F80A29EC0FC');
        $this->addSql('DROP TABLE sip_manuf_rubric');
        $this->addSql('DROP INDEX IDX_AC136F80A29EC0FC ON sip_manufacturer');
        $this->addSql('ALTER TABLE sip_manufacturer DROP rubric_id');
    }
}
