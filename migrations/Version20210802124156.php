<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802124156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, slot9h INT DEFAULT NULL, slot10h INT DEFAULT NULL, slot11h INT DEFAULT NULL, slot12h INT DEFAULT NULL, slot14h INT DEFAULT NULL, slot15h INT DEFAULT NULL, slot16h INT DEFAULT NULL, slot17h INT DEFAULT NULL, date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_user (day_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_26FB3B3F9C24126 (day_id), INDEX IDX_26FB3B3FA76ED395 (user_id), PRIMARY KEY(day_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_game (day_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_8843DCFA9C24126 (day_id), INDEX IDX_8843DCFAE48FD905 (game_id), PRIMARY KEY(day_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day_user ADD CONSTRAINT FK_26FB3B3F9C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_user ADD CONSTRAINT FK_26FB3B3FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_game ADD CONSTRAINT FK_8843DCFA9C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_game ADD CONSTRAINT FK_8843DCFAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day_user DROP FOREIGN KEY FK_26FB3B3F9C24126');
        $this->addSql('ALTER TABLE day_game DROP FOREIGN KEY FK_8843DCFA9C24126');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE day_user');
        $this->addSql('DROP TABLE day_game');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D461778466');
        $this->addSql('DROP INDEX IDX_D044D5D461778466 ON session');
    }
}
