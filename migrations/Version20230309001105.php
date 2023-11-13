<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309001105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE home (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE home_user (home_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_ACB5678628CDC89C (home_id), INDEX IDX_ACB56786A76ED395 (user_id), PRIMARY KEY(home_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE home_music (home_id INT NOT NULL, music_id INT NOT NULL, INDEX IDX_C6A8DBDA28CDC89C (home_id), INDEX IDX_C6A8DBDA399BBB13 (music_id), PRIMARY KEY(home_id, music_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE home_user ADD CONSTRAINT FK_ACB5678628CDC89C FOREIGN KEY (home_id) REFERENCES home (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE home_user ADD CONSTRAINT FK_ACB56786A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE home_music ADD CONSTRAINT FK_C6A8DBDA28CDC89C FOREIGN KEY (home_id) REFERENCES home (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE home_music ADD CONSTRAINT FK_C6A8DBDA399BBB13 FOREIGN KEY (music_id) REFERENCES music (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE music CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE home_user DROP FOREIGN KEY FK_ACB5678628CDC89C');
        $this->addSql('ALTER TABLE home_user DROP FOREIGN KEY FK_ACB56786A76ED395');
        $this->addSql('ALTER TABLE home_music DROP FOREIGN KEY FK_C6A8DBDA28CDC89C');
        $this->addSql('ALTER TABLE home_music DROP FOREIGN KEY FK_C6A8DBDA399BBB13');
        $this->addSql('DROP TABLE home');
        $this->addSql('DROP TABLE home_user');
        $this->addSql('DROP TABLE home_music');
        $this->addSql('ALTER TABLE music CHANGE categorie_id categorie_id INT NOT NULL');
    }
}
