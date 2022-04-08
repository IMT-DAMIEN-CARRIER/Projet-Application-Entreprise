<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324155306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element_formation ADD father_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE element_formation ADD CONSTRAINT FK_E84B0F942055B9A2 FOREIGN KEY (father_id) REFERENCES element_formation (id)');
        $this->addSql('CREATE INDEX IDX_E84B0F942055B9A2 ON element_formation (father_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element_formation DROP FOREIGN KEY FK_E84B0F942055B9A2');
        $this->addSql('DROP INDEX IDX_E84B0F942055B9A2 ON element_formation');
        $this->addSql('ALTER TABLE element_formation DROP father_id');
    }
}
