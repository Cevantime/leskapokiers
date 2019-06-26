<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626163717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, firstname VARCHAR(80) DEFAULT NULL, lastname VARCHAR(80) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, age INT DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, pseudonym VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_15996877E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spectacles (id INT AUTO_INCREMENT NOT NULL, presskit_id INT DEFAULT NULL, big_image_id INT NOT NULL, small_image_id INT NOT NULL, author_id INT DEFAULT NULL, director_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, creation_date DATE DEFAULT NULL, summary LONGTEXT DEFAULT NULL, tape VARCHAR(255) DEFAULT NULL, critics LONGTEXT DEFAULT NULL, rewards LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_A13BA9785FEEFD8 (presskit_id), UNIQUE INDEX UNIQ_A13BA9785272F7EF (big_image_id), UNIQUE INDEX UNIQ_A13BA978D9E4E1BC (small_image_id), INDEX IDX_A13BA978F675F31B (author_id), INDEX IDX_A13BA978899FB366 (director_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_medium (show_id INT NOT NULL, medium_id INT NOT NULL, INDEX IDX_49146A2CD0C1FC64 (show_id), INDEX IDX_49146A2CE252B6A5 (medium_id), PRIMARY KEY(show_id, medium_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_actor (show_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_46C43225D0C1FC64 (show_id), INDEX IDX_46C43225B7970CF8 (artist_id), PRIMARY KEY(show_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medium (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, api_id VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(50) DEFAULT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_15996877E9E4C8C FOREIGN KEY (photo_id) REFERENCES medium (id)');
        $this->addSql('ALTER TABLE spectacles ADD CONSTRAINT FK_A13BA9785FEEFD8 FOREIGN KEY (presskit_id) REFERENCES medium (id)');
        $this->addSql('ALTER TABLE spectacles ADD CONSTRAINT FK_A13BA9785272F7EF FOREIGN KEY (big_image_id) REFERENCES medium (id)');
        $this->addSql('ALTER TABLE spectacles ADD CONSTRAINT FK_A13BA978D9E4E1BC FOREIGN KEY (small_image_id) REFERENCES medium (id)');
        $this->addSql('ALTER TABLE spectacles ADD CONSTRAINT FK_A13BA978F675F31B FOREIGN KEY (author_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE spectacles ADD CONSTRAINT FK_A13BA978899FB366 FOREIGN KEY (director_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE show_medium ADD CONSTRAINT FK_49146A2CD0C1FC64 FOREIGN KEY (show_id) REFERENCES spectacles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_medium ADD CONSTRAINT FK_49146A2CE252B6A5 FOREIGN KEY (medium_id) REFERENCES medium (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_actor ADD CONSTRAINT FK_46C43225D0C1FC64 FOREIGN KEY (show_id) REFERENCES spectacles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_actor ADD CONSTRAINT FK_46C43225B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE spectacles DROP FOREIGN KEY FK_A13BA978F675F31B');
        $this->addSql('ALTER TABLE spectacles DROP FOREIGN KEY FK_A13BA978899FB366');
        $this->addSql('ALTER TABLE show_actor DROP FOREIGN KEY FK_46C43225B7970CF8');
        $this->addSql('ALTER TABLE show_medium DROP FOREIGN KEY FK_49146A2CD0C1FC64');
        $this->addSql('ALTER TABLE show_actor DROP FOREIGN KEY FK_46C43225D0C1FC64');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_15996877E9E4C8C');
        $this->addSql('ALTER TABLE spectacles DROP FOREIGN KEY FK_A13BA9785FEEFD8');
        $this->addSql('ALTER TABLE spectacles DROP FOREIGN KEY FK_A13BA9785272F7EF');
        $this->addSql('ALTER TABLE spectacles DROP FOREIGN KEY FK_A13BA978D9E4E1BC');
        $this->addSql('ALTER TABLE show_medium DROP FOREIGN KEY FK_49146A2CE252B6A5');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE spectacles');
        $this->addSql('DROP TABLE show_medium');
        $this->addSql('DROP TABLE show_actor');
        $this->addSql('DROP TABLE medium');
    }
}
