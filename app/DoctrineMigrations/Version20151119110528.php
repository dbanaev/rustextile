<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151119110528 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_publishing DROP FOREIGN KEY FK_93CF4CB0C54C8C93');
        $this->addSql('DROP INDEX IDX_93CF4CB0C54C8C93 ON sip_publishing');
        $this->addSql('ALTER TABLE sip_publishing DROP type_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_publishing ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_publishing ADD CONSTRAINT FK_93CF4CB0C54C8C93 FOREIGN KEY (type_id) REFERENCES sip_publishing_type (id)');
        $this->addSql('CREATE INDEX IDX_93CF4CB0C54C8C93 ON sip_publishing (type_id)');
    }
}
