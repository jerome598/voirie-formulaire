<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115142034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE incidents (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, technician INT NOT NULL, t_group INT NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, nom VARCHAR(50) NOT NULL, tel VARCHAR(20) NOT NULL, `use` VARCHAR(50) NOT NULL, email VARCHAR(255) DEFAULT NULL, date_create DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_modif DATETIME NOT NULL, date_import DATETIME DEFAULT NULL, state INT NOT NULL, priority INT NOT NULL, criticality INT NOT NULL, category INT NOT NULL, techread INT NOT NULL, disable INT NOT NULL, place INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE incidents');
    }
}
