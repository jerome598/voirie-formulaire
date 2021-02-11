<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120154431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incidents ADD places_id INT NOT NULL');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D08317B347 FOREIGN KEY (places_id) REFERENCES tplaces (id)');
        $this->addSql('CREATE INDEX IDX_E65135D08317B347 ON incidents (places_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incidents DROP FOREIGN KEY FK_E65135D08317B347');
        $this->addSql('DROP INDEX IDX_E65135D08317B347 ON incidents');
        $this->addSql('ALTER TABLE incidents DROP places_id');
    }
}
