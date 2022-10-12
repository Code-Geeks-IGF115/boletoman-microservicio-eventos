<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010044629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento ADD sala_de_eventos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05ADDC7720 FOREIGN KEY (sala_de_eventos_id) REFERENCES sala_de_eventos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_47860B05ADDC7720 ON evento (sala_de_eventos_id)');
        $this->addSql('ALTER TABLE sala_de_eventos DROP CONSTRAINT fk_a969543787a5f842');
        $this->addSql('DROP INDEX uniq_a969543787a5f842');
        $this->addSql('ALTER TABLE sala_de_eventos DROP evento_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE evento DROP CONSTRAINT FK_47860B05ADDC7720');
        $this->addSql('DROP INDEX IDX_47860B05ADDC7720');
        $this->addSql('ALTER TABLE evento DROP sala_de_eventos_id');
        $this->addSql('ALTER TABLE sala_de_eventos ADD evento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sala_de_eventos ADD CONSTRAINT fk_a969543787a5f842 FOREIGN KEY (evento_id) REFERENCES evento (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_a969543787a5f842 ON sala_de_eventos (evento_id)');
    }
}
