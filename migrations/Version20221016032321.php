<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221016032321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categoria_evento_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evento_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE frecuencia_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE imagen_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categoria_evento (id INT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE evento (id INT NOT NULL, categoria_id INT NOT NULL, nombre VARCHAR(50) NOT NULL, descripcion VARCHAR(255) NOT NULL, tipo_de_evento VARCHAR(25) NOT NULL, fecha_inicio DATE NOT NULL, hora_inicio TIME(0) WITHOUT TIME ZONE NOT NULL, fecha_fin DATE NOT NULL, hora_fin TIME(0) WITHOUT TIME ZONE NOT NULL, sala_de_eventos_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47860B053397707A ON evento (categoria_id)');
        $this->addSql('CREATE TABLE frecuencia (id INT NOT NULL, dia INT NOT NULL, checked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE imagen (id INT NOT NULL, evento_id INT NOT NULL, descripcion VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8319D2B387A5F842 ON imagen (evento_id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B053397707A FOREIGN KEY (categoria_id) REFERENCES categoria_evento (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B387A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categoria_evento_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evento_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE frecuencia_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE imagen_id_seq CASCADE');
        $this->addSql('ALTER TABLE evento DROP CONSTRAINT FK_47860B053397707A');
        $this->addSql('ALTER TABLE imagen DROP CONSTRAINT FK_8319D2B387A5F842');
        $this->addSql('DROP TABLE categoria_evento');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE frecuencia');
        $this->addSql('DROP TABLE imagen');
    }
}
