<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528150948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE post_images_id_seq CASCADE');
        $this->addSql('ALTER TABLE post_images DROP CONSTRAINT fk_d03d5a0f4b89032c');
        $this->addSql('DROP TABLE post_images');
        $this->addSql('ALTER TABLE post ADD file_path TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE post_images_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE post_images (id INT NOT NULL, post_id INT DEFAULT NULL, path TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d03d5a0f4b89032c ON post_images (post_id)');
        $this->addSql('ALTER TABLE post_images ADD CONSTRAINT fk_d03d5a0f4b89032c FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post DROP file_path');
    }
}
