<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921092013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE att_prods (id INT AUTO_INCREMENT NOT NULL, attributs_id INT DEFAULT NULL, products_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_D306DAD9C39426B9 (attributs_id), INDEX IDX_D306DAD96C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attributs (id INT AUTO_INCREMENT NOT NULL, attributs_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_sub_categories (categories_id INT NOT NULL, sub_categories_id INT NOT NULL, INDEX IDX_A7C75631A21214B7 (categories_id), INDEX IDX_A7C756316DBFD369 (sub_categories_id), PRIMARY KEY(categories_id, sub_categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE histories (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, added_at DATETIME NOT NULL, INDEX IDX_CFF1CEA367B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, products_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A6C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating_coms (id INT AUTO_INCREMENT NOT NULL, products_id INT DEFAULT NULL, users_id INT DEFAULT NULL, rate INT NOT NULL, comment_content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_967BAD056C8A81A9 (products_id), INDEX IDX_967BAD0567B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stocks (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, username VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE att_prods ADD CONSTRAINT FK_D306DAD9C39426B9 FOREIGN KEY (attributs_id) REFERENCES attributs (id)');
        $this->addSql('ALTER TABLE att_prods ADD CONSTRAINT FK_D306DAD96C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE categories_sub_categories ADD CONSTRAINT FK_A7C75631A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_sub_categories ADD CONSTRAINT FK_A7C756316DBFD369 FOREIGN KEY (sub_categories_id) REFERENCES sub_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE histories ADD CONSTRAINT FK_CFF1CEA367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE rating_coms ADD CONSTRAINT FK_967BAD056C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE rating_coms ADD CONSTRAINT FK_967BAD0567B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE products ADD stocks_id INT DEFAULT NULL, ADD histories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AFACB6020 FOREIGN KEY (stocks_id) REFERENCES stocks (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A22BC1E8C FOREIGN KEY (histories_id) REFERENCES histories (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AFACB6020 ON products (stocks_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A22BC1E8C ON products (histories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A22BC1E8C');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AFACB6020');
        $this->addSql('ALTER TABLE att_prods DROP FOREIGN KEY FK_D306DAD9C39426B9');
        $this->addSql('ALTER TABLE att_prods DROP FOREIGN KEY FK_D306DAD96C8A81A9');
        $this->addSql('ALTER TABLE categories_sub_categories DROP FOREIGN KEY FK_A7C75631A21214B7');
        $this->addSql('ALTER TABLE categories_sub_categories DROP FOREIGN KEY FK_A7C756316DBFD369');
        $this->addSql('ALTER TABLE histories DROP FOREIGN KEY FK_CFF1CEA367B3B43D');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A6C8A81A9');
        $this->addSql('ALTER TABLE rating_coms DROP FOREIGN KEY FK_967BAD056C8A81A9');
        $this->addSql('ALTER TABLE rating_coms DROP FOREIGN KEY FK_967BAD0567B3B43D');
        $this->addSql('DROP TABLE att_prods');
        $this->addSql('DROP TABLE attributs');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_sub_categories');
        $this->addSql('DROP TABLE histories');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE rating_coms');
        $this->addSql('DROP TABLE stocks');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_B3BA5A5AFACB6020 ON products');
        $this->addSql('DROP INDEX IDX_B3BA5A5A22BC1E8C ON products');
        $this->addSql('ALTER TABLE products DROP stocks_id, DROP histories_id');
    }
}
