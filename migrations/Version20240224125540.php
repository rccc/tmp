<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240224125540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experimentation ADD num_item VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE experimentation ADD type_echantillon VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE experimentation ADD nom_rec_dev VARCHAR(25) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE experimentation DROP num_item');
        $this->addSql('ALTER TABLE experimentation DROP type_echantillon');
        $this->addSql('ALTER TABLE experimentation DROP nom_rec_dev');
    }
}
