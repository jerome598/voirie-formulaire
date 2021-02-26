<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225095022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tincidents CHANGE date_modif date_modif DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tincidents RENAME INDEX idx_e65135d08317b347 TO IDX_1C706CEADA6A219');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tincidents CHANGE date_modif date_modif DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tincidents RENAME INDEX idx_1c706ceada6a219 TO IDX_E65135D08317B347');
    }
}
