<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015112541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (ref INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club ADD ref INT AUTO_INCREMENT NOT NULL, DROP id, ADD PRIMARY KEY (ref)');
        $this->addSql('ALTER TABLE student MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON student');
        $this->addSql('ALTER TABLE student CHANGE id nsc INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE student ADD PRIMARY KEY (nsc)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE club MODIFY ref INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON club');
        $this->addSql('ALTER TABLE club ADD id INT NOT NULL, DROP ref');
        $this->addSql('ALTER TABLE student MODIFY nsc INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON student');
        $this->addSql('ALTER TABLE student CHANGE nsc id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE student ADD PRIMARY KEY (id)');
    }
}
