<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302133059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_CD52224ABCF5E72D ON music (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224ABCF5E72D');
        $this->addSql('DROP INDEX IDX_CD52224ABCF5E72D ON music');
        $this->addSql('ALTER TABLE music DROP categorie_id');
    }
}
