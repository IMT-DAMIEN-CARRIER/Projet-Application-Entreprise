<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324135441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE element_formation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element_formation_groupe (element_formation_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_2BB38BD7FACD5123 (element_formation_id), INDEX IDX_2BB38BD77A45358C (groupe_id), PRIMARY KEY(element_formation_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element_formation_reservation (element_formation_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_7E069AAFACD5123 (element_formation_id), INDEX IDX_7E069AAB83297E7 (reservation_id), PRIMARY KEY(element_formation_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE element_formation_groupe ADD CONSTRAINT FK_2BB38BD7FACD5123 FOREIGN KEY (element_formation_id) REFERENCES element_formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE element_formation_groupe ADD CONSTRAINT FK_2BB38BD77A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE element_formation_reservation ADD CONSTRAINT FK_7E069AAFACD5123 FOREIGN KEY (element_formation_id) REFERENCES element_formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE element_formation_reservation ADD CONSTRAINT FK_7E069AAB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD element_formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FACD5123 FOREIGN KEY (element_formation_id) REFERENCES element_formation (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14FACD5123 ON note (element_formation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE element_formation_groupe DROP FOREIGN KEY FK_2BB38BD7FACD5123');
        $this->addSql('ALTER TABLE element_formation_reservation DROP FOREIGN KEY FK_7E069AAFACD5123');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FACD5123');
        $this->addSql('DROP TABLE element_formation');
        $this->addSql('DROP TABLE element_formation_groupe');
        $this->addSql('DROP TABLE element_formation_reservation');
        $this->addSql('DROP INDEX IDX_CFBDFA14FACD5123 ON note');
        $this->addSql('ALTER TABLE note DROP element_formation_id');
    }
}
