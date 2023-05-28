<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528145923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE conversation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE participant_id_seq CASCADE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307f9ac0396');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307ff675f31b');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT fk_8a8e26e9ba0e79c3');
        $this->addSql('ALTER TABLE participant DROP CONSTRAINT fk_d79f6b119ac0396');
        $this->addSql('ALTER TABLE participant DROP CONSTRAINT fk_d79f6b11f675f31b');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE participant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE conversation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE participant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, conversation_id INT DEFAULT NULL, author_id INT DEFAULT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_b6bd307ff675f31b ON message (author_id)');
        $this->addSql('CREATE INDEX idx_b6bd307f9ac0396 ON message (conversation_id)');
        $this->addSql('CREATE TABLE conversation (id INT NOT NULL, last_message_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8a8e26e9ba0e79c3 ON conversation (last_message_id)');
        $this->addSql('CREATE TABLE participant (id INT NOT NULL, conversation_id INT DEFAULT NULL, author_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d79f6b11f675f31b ON participant (author_id)');
        $this->addSql('CREATE INDEX idx_d79f6b119ac0396 ON participant (conversation_id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307f9ac0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307ff675f31b FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT fk_8a8e26e9ba0e79c3 FOREIGN KEY (last_message_id) REFERENCES message (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT fk_d79f6b119ac0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT fk_d79f6b11f675f31b FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
