<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260208103214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE download_item (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE gallery_item (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date_label VARCHAR(255) NOT NULL, detail LONGTEXT NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, hours VARCHAR(255) NOT NULL, focus LONGTEXT NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE site_content (id INT AUTO_INCREMENT NOT NULL, hero_title VARCHAR(255) NOT NULL, hero_subtitle VARCHAR(255) NOT NULL, hero_description LONGTEXT NOT NULL, phone VARCHAR(50) NOT NULL, whatsapp VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tariff (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE download_item');
        $this->addSql('DROP TABLE gallery_item');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE site_content');
        $this->addSql('DROP TABLE tariff');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
