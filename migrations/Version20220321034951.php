<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321034951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE file_user');
        $this->addSql('DROP INDEX UNIQ_8C9F3610A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__file AS SELECT id, user_id, name, description, filename FROM file');
        $this->addSql('DROP TABLE file');
        $this->addSql('CREATE TABLE file (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, filename VARCHAR(255) NOT NULL, CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO file (id, user_id, name, description, filename) SELECT id, user_id, name, description, filename FROM __temp__file');
        $this->addSql('DROP TABLE __temp__file');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F3610A76ED395 ON file (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_user (file_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(file_id, user_id))');
        $this->addSql('CREATE INDEX IDX_46FBE27A76ED395 ON file_user (user_id)');
        $this->addSql('CREATE INDEX IDX_46FBE2793CB796C ON file_user (file_id)');
        $this->addSql('DROP INDEX UNIQ_8C9F3610A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__file AS SELECT id, user_id, name, description, filename FROM file');
        $this->addSql('DROP TABLE file');
        $this->addSql('CREATE TABLE file (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, filename VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO file (id, user_id, name, description, filename) SELECT id, user_id, name, description, filename FROM __temp__file');
        $this->addSql('DROP TABLE __temp__file');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F3610A76ED395 ON file (user_id)');
    }
}
