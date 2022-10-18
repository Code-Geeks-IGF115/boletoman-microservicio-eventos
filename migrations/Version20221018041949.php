<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018041949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frecuencia ADD evento_id INT NOT NULL');
        $this->addSql('ALTER TABLE frecuencia ADD CONSTRAINT FK_D6AC1F9387A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D6AC1F9387A5F842 ON frecuencia (evento_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE frecuencia DROP CONSTRAINT FK_D6AC1F9387A5F842');
        $this->addSql('DROP INDEX IDX_D6AC1F9387A5F842');
        $this->addSql('ALTER TABLE frecuencia DROP evento_id');
    }
}
