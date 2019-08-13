<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812094514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE forms (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(100) NOT NULL, form_data_json JSON NOT NULL COMMENT \'(DC2Type:json_array)\', name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_tasks (id INT AUTO_INCREMENT NOT NULL, tasks_id INT NOT NULL, form_id INT NOT NULL, form_data_json JSON NOT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_D31FC154E3272D31 (tasks_id), INDEX IDX_D31FC1545FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_category (id INT AUTO_INCREMENT NOT NULL, catagory_name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, description LONGTEXT NOT NULL, title VARCHAR(100) NOT NULL, created_date DATETIME NOT NULL, status VARCHAR(30) DEFAULT NULL, INDEX IDX_5058659712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks_surveyors (tasks_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_60790CF2E3272D31 (tasks_id), INDEX IDX_60790CF267B3B43D (users_id), PRIMARY KEY(tasks_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_task (tasks_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_83E21847E3272D31 (tasks_id), INDEX IDX_83E2184767B3B43D (users_id), PRIMARY KEY(tasks_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_country (id INT AUTO_INCREMENT NOT NULL, country_code VARCHAR(10) NOT NULL, country_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, countries_id INT NOT NULL, profile_pic_id INT DEFAULT NULL, first_name VARCHAR(120) NOT NULL, last_name VARCHAR(120) NOT NULL, username VARCHAR(60) NOT NULL, password VARCHAR(70) NOT NULL, roles TINYTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', email VARCHAR(100) NOT NULL, password_change_date INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, confirmation_token VARCHAR(50) DEFAULT NULL, created_date DATETIME NOT NULL, INDEX IDX_1483A5E9AEBAE514 (countries_id), UNIQUE INDEX UNIQ_1483A5E9F67B9AF6 (profile_pic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE form_tasks ADD CONSTRAINT FK_D31FC154E3272D31 FOREIGN KEY (tasks_id) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE form_tasks ADD CONSTRAINT FK_D31FC1545FF69B7D FOREIGN KEY (form_id) REFERENCES forms (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659712469DE2 FOREIGN KEY (category_id) REFERENCES task_category (id)');
        $this->addSql('ALTER TABLE tasks_surveyors ADD CONSTRAINT FK_60790CF2E3272D31 FOREIGN KEY (tasks_id) REFERENCES tasks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks_surveyors ADD CONSTRAINT FK_60790CF267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_task ADD CONSTRAINT FK_83E21847E3272D31 FOREIGN KEY (tasks_id) REFERENCES tasks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_task ADD CONSTRAINT FK_83E2184767B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AEBAE514 FOREIGN KEY (countries_id) REFERENCES user_country (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9F67B9AF6 FOREIGN KEY (profile_pic_id) REFERENCES images (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE form_tasks DROP FOREIGN KEY FK_D31FC1545FF69B7D');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9F67B9AF6');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_5058659712469DE2');
        $this->addSql('ALTER TABLE form_tasks DROP FOREIGN KEY FK_D31FC154E3272D31');
        $this->addSql('ALTER TABLE tasks_surveyors DROP FOREIGN KEY FK_60790CF2E3272D31');
        $this->addSql('ALTER TABLE client_task DROP FOREIGN KEY FK_83E21847E3272D31');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AEBAE514');
        $this->addSql('ALTER TABLE tasks_surveyors DROP FOREIGN KEY FK_60790CF267B3B43D');
        $this->addSql('ALTER TABLE client_task DROP FOREIGN KEY FK_83E2184767B3B43D');
        $this->addSql('DROP TABLE forms');
        $this->addSql('DROP TABLE form_tasks');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE task_category');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE tasks_surveyors');
        $this->addSql('DROP TABLE client_task');
        $this->addSql('DROP TABLE user_country');
        $this->addSql('DROP TABLE users');
    }
}
