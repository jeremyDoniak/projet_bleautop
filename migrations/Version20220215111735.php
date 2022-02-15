<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215111735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, types_id INT DEFAULT NULL, size_id INT DEFAULT NULL, color_id INT DEFAULT NULL, angle_id INT DEFAULT NULL, drilling_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, img VARCHAR(45) NOT NULL, price DOUBLE PRECISION NOT NULL, category VARCHAR(45) NOT NULL, description LONGTEXT NOT NULL, height INT DEFAULT NULL, width INT DEFAULT NULL, length INT DEFAULT NULL, INDEX IDX_D34A04AD8EB23357 (types_id), INDEX IDX_D34A04AD498DA827 (size_id), INDEX IDX_D34A04AD7ADA1FB5 (color_id), INDEX IDX_D34A04AD7E21F649 (angle_id), INDEX IDX_D34A04AD74ACE14F (drilling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8EB23357 FOREIGN KEY (types_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E21F649 FOREIGN KEY (angle_id) REFERENCES angle (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD74ACE14F FOREIGN KEY (drilling_id) REFERENCES drilling (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
    }
}
