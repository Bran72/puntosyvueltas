<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190416212602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE gamme_id gamme_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE prix prix INT DEFAULT NULL, CHANGE fil fil VARCHAR(255) DEFAULT NULL, CHANGE surmesure surmesure TINYINT(1) DEFAULT NULL, CHANGE photos photos JSON DEFAULT NULL, CHANGE dimensions dimensions VARCHAR(255) DEFAULT NULL, CHANGE duree duree VARCHAR(255) DEFAULT NULL, CHANGE taille_fils taille_fils VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE gamme_id gamme_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE prix prix INT NOT NULL, CHANGE fil fil VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE surmesure surmesure TINYINT(1) NOT NULL, CHANGE photos photos LONGTEXT DEFAULT NULL COLLATE utf8mb4_bin, CHANGE dimensions dimensions VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE duree duree VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE taille_fils taille_fils VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
