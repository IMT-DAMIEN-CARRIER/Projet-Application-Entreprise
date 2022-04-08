<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324134703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_salle (reservation_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_DE8AEFBB83297E7 (reservation_id), INDEX IDX_DE8AEFBDC304035 (salle_id), PRIMARY KEY(reservation_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_user (reservation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9BAA1B21B83297E7 (reservation_id), INDEX IDX_9BAA1B21A76ED395 (user_id), PRIMARY KEY(reservation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_salle ADD CONSTRAINT FK_DE8AEFBB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_salle ADD CONSTRAINT FK_DE8AEFBDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_user ADD CONSTRAINT FK_9BAA1B21B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_user ADD CONSTRAINT FK_9BAA1B21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_salle DROP FOREIGN KEY FK_DE8AEFBB83297E7');
        $this->addSql('ALTER TABLE reservation_user DROP FOREIGN KEY FK_9BAA1B21B83297E7');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_salle');
        $this->addSql('DROP TABLE reservation_user');
    }
}
