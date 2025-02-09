<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205095428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id SERIAL NOT NULL, category_id INT DEFAULT NULL, subcategory_id INT DEFAULT NULL, publication_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content TEXT NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E6612469DE2 ON article (category_id)');
        $this->addSql('CREATE INDEX IDX_23A0E665DC6FE57 ON article (subcategory_id)');
        $this->addSql('CREATE TABLE article_user (article_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(article_id, user_id))');
        $this->addSql('CREATE INDEX IDX_3DD151487294869C ON article_user (article_id)');
        $this->addSql('CREATE INDEX IDX_3DD15148A76ED395 ON article_user (user_id)');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subcategory (id SERIAL NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DDCA44812469DE2 ON subcategory (category_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, login VARCHAR(60) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_user ADD CONSTRAINT FK_3DD151487294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_user ADD CONSTRAINT FK_3DD15148A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E665DC6FE57');
        $this->addSql('ALTER TABLE article_user DROP CONSTRAINT FK_3DD151487294869C');
        $this->addSql('ALTER TABLE article_user DROP CONSTRAINT FK_3DD15148A76ED395');
        $this->addSql('ALTER TABLE subcategory DROP CONSTRAINT FK_DDCA44812469DE2');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE subcategory');
        $this->addSql('DROP TABLE "user"');
    }
}
