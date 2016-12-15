<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151108151856 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_event_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_event ADD type_id INT DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD publish TINYINT(1) DEFAULT NULL, CHANGE brief brief LONGTEXT DEFAULT NULL, CHANGE full full LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE sip_event ADD CONSTRAINT FK_CBFC79DC54C8C93 FOREIGN KEY (type_id) REFERENCES sip_event_type (id)');
        $this->addSql('CREATE INDEX IDX_CBFC79DC54C8C93 ON sip_event (type_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_event DROP FOREIGN KEY FK_CBFC79DC54C8C93');
        $this->addSql('DROP TABLE sip_event_type');
        $this->addSql('DROP INDEX IDX_CBFC79DC54C8C93 ON sip_event');
        $this->addSql('ALTER TABLE sip_event DROP type_id, DROP slug, DROP publish, CHANGE brief brief VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE full full VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
