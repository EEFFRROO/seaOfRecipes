<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220925094418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, volume INT DEFAULT NULL, weight INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS ingredient_recipe_relation (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, ingredient_id INT NOT NULL, count DOUBLE PRECISION NOT NULL, INDEX IDX_8EC8E63859D8A214 (recipe_id), INDEX IDX_8EC8E638933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS recipe (id INT AUTO_INCREMENT NOT NULL, cook_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, text VARCHAR(4095) NOT NULL, INDEX IDX_DA88B137B0D5B835 (cook_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS review (id INT AUTO_INCREMENT NOT NULL, reviewer_id INT NOT NULL, recipe_id INT NOT NULL, text VARCHAR(4095) DEFAULT NULL, INDEX IDX_794381C670574616 (reviewer_id), INDEX IDX_794381C659D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE IF EXISTS ingredient_recipe_relation ADD CONSTRAINT FK_8EC8E63859D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE IF EXISTS ingredient_recipe_relation ADD CONSTRAINT FK_8EC8E638933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE IF EXISTS recipe ADD CONSTRAINT FK_DA88B137B0D5B835 FOREIGN KEY (cook_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE IF EXISTS review ADD CONSTRAINT FK_794381C670574616 FOREIGN KEY (reviewer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE IF EXISTS review ADD CONSTRAINT FK_794381C659D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE IF EXISTS ingredient_recipe_relation DROP FOREIGN KEY FK_8EC8E63859D8A214');
        $this->addSql('ALTER TABLE IF EXISTS ingredient_recipe_relation DROP FOREIGN KEY FK_8EC8E638933FE08C');
        $this->addSql('ALTER TABLE IF EXISTS recipe DROP FOREIGN KEY FK_DA88B137B0D5B835');
        $this->addSql('ALTER TABLE IF EXISTS review DROP FOREIGN KEY FK_794381C670574616');
        $this->addSql('ALTER TABLE IF EXISTS review DROP FOREIGN KEY FK_794381C659D8A214');
        $this->addSql('DROP TABLE IF EXISTS ingredient');
        $this->addSql('DROP TABLE IF EXISTS ingredient_recipe_relation');
        $this->addSql('DROP TABLE IF EXISTS recipe');
        $this->addSql('DROP TABLE IF EXISTS review');
        $this->addSql('DROP TABLE IF EXISTS `user`');
    }
}
