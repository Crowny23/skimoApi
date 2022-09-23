<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921085333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_sub_categories (products_id INT NOT NULL, sub_categories_id INT NOT NULL, INDEX IDX_48D725026C8A81A9 (products_id), INDEX IDX_48D725026DBFD369 (sub_categories_id), PRIMARY KEY(products_id, sub_categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_categories (id INT AUTO_INCREMENT NOT NULL, subcategory_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_sub_categories ADD CONSTRAINT FK_48D725026C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_sub_categories ADD CONSTRAINT FK_48D725026DBFD369 FOREIGN KEY (sub_categories_id) REFERENCES sub_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_sub_categories DROP FOREIGN KEY FK_48D725026C8A81A9');
        $this->addSql('ALTER TABLE products_sub_categories DROP FOREIGN KEY FK_48D725026DBFD369');
        $this->addSql('DROP TABLE products_sub_categories');
        $this->addSql('DROP TABLE sub_categories');
    }
}
