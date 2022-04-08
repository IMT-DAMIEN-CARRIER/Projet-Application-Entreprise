<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324155059 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element_formation DROP FOREIGN KEY FK_E84B0F94E6B9712F');
        $this->addSql('DROP INDEX IDX_E84B0F94E6B9712F ON element_formation');
        $this->addSql('ALTER TABLE element_formation DROP fils_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element_formation ADD fils_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE element_formation ADD CONSTRAINT FK_E84B0F94E6B9712F FOREIGN KEY (fils_id) REFERENCES element_formation (id)');
        $this->addSql('CREATE INDEX IDX_E84B0F94E6B9712F ON element_formation (fils_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
