<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151118111747 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sip_news_rubric (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sip_publishing_rubric (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sip_news ADD rubric_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_news ADD CONSTRAINT FK_D42553BBA29EC0FC FOREIGN KEY (rubric_id) REFERENCES sip_news_rubric (id)');
        $this->addSql('CREATE INDEX IDX_D42553BBA29EC0FC ON sip_news (rubric_id)');
        $this->addSql('ALTER TABLE sip_publishing ADD rubric_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sip_publishing ADD CONSTRAINT FK_93CF4CB0A29EC0FC FOREIGN KEY (rubric_id) REFERENCES sip_publishing_rubric (id)');
        $this->addSql('CREATE INDEX IDX_93CF4CB0A29EC0FC ON sip_publishing (rubric_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sip_news DROP FOREIGN KEY FK_D42553BBA29EC0FC');
        $this->addSql('ALTER TABLE sip_publishing DROP FOREIGN KEY FK_93CF4CB0A29EC0FC');
        $this->addSql('DROP TABLE sip_news_rubric');
        $this->addSql('DROP TABLE sip_publishing_rubric');
        $this->addSql('DROP INDEX IDX_D42553BBA29EC0FC ON sip_news');
        $this->addSql('ALTER TABLE sip_news DROP rubric_id');
        $this->addSql('DROP INDEX IDX_93CF4CB0A29EC0FC ON sip_publishing');
        $this->addSql('ALTER TABLE sip_publishing DROP rubric_id');
    }
}
