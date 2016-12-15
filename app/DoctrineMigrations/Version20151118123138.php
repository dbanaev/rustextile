<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151118123138 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_news DROP FOREIGN KEY FK_D42553BBC54C8C93');
        $this->addSql('DROP TABLE sip_news_type');
        $this->addSql('DROP INDEX IDX_D42553BBC54C8C93 ON sip_news');
        $this->addSql('ALTER TABLE sip_news DROP type_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_news_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_news ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_news ADD CONSTRAINT FK_D42553BBC54C8C93 FOREIGN KEY (type_id) REFERENCES sip_news_type (id)');
        $this->addSql('CREATE INDEX IDX_D42553BBC54C8C93 ON sip_news (type_id)');
    }
}
