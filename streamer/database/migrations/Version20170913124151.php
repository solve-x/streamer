<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170913124151 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE streams (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, stream_key VARCHAR(255) NOT NULL, created DATETIME NOT NULL, INDEX IDX_FFF7AFAC54C8C93 (type_id), INDEX IDX_FFF7AFAB03A8386 (created_by_id), UNIQUE INDEX idx_unique_stream_key (stream_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_roles (id INT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX idx_unique_name_label (name, label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream_types (id INT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX idx_unique_name_label (name, label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX idx_unique_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_user_roles (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_83977A0BA76ED395 (user_id), INDEX IDX_83977A0BD60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles (id INT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX idx_unique_name_label (name, label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_stream_roles (user_id INT NOT NULL, role_id INT NOT NULL, stream_id INT NOT NULL, INDEX IDX_799AB7AEA76ED395 (user_id), INDEX IDX_799AB7AED60322AC (role_id), INDEX IDX_799AB7AED0ED463E (stream_id), PRIMARY KEY(user_id, role_id, stream_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE streams ADD CONSTRAINT FK_FFF7AFAC54C8C93 FOREIGN KEY (type_id) REFERENCES stream_types (id)');
        $this->addSql('ALTER TABLE streams ADD CONSTRAINT FK_FFF7AFAB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_user_roles ADD CONSTRAINT FK_83977A0BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_user_roles ADD CONSTRAINT FK_83977A0BD60322AC FOREIGN KEY (role_id) REFERENCES user_roles (id)');
        $this->addSql('ALTER TABLE user_stream_roles ADD CONSTRAINT FK_799AB7AEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_stream_roles ADD CONSTRAINT FK_799AB7AED60322AC FOREIGN KEY (role_id) REFERENCES stream_roles (id)');
        $this->addSql('ALTER TABLE user_stream_roles ADD CONSTRAINT FK_799AB7AED0ED463E FOREIGN KEY (stream_id) REFERENCES streams (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_stream_roles DROP FOREIGN KEY FK_799AB7AED0ED463E');
        $this->addSql('ALTER TABLE user_stream_roles DROP FOREIGN KEY FK_799AB7AED60322AC');
        $this->addSql('ALTER TABLE streams DROP FOREIGN KEY FK_FFF7AFAC54C8C93');
        $this->addSql('ALTER TABLE streams DROP FOREIGN KEY FK_FFF7AFAB03A8386');
        $this->addSql('ALTER TABLE users_user_roles DROP FOREIGN KEY FK_83977A0BA76ED395');
        $this->addSql('ALTER TABLE user_stream_roles DROP FOREIGN KEY FK_799AB7AEA76ED395');
        $this->addSql('ALTER TABLE users_user_roles DROP FOREIGN KEY FK_83977A0BD60322AC');
        $this->addSql('DROP TABLE streams');
        $this->addSql('DROP TABLE stream_roles');
        $this->addSql('DROP TABLE stream_types');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_user_roles');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('DROP TABLE user_stream_roles');
    }
}
