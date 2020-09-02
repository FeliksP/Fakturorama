<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902214709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice_items (id INT AUTO_INCREMENT NOT NULL, invoice_id_id INT NOT NULL, product VARCHAR(255) NOT NULL, quantity INT NOT NULL, price INT NOT NULL, total INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DCC4B9F8429ECEE2 (invoice_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(25) NOT NULL, issue_date DATE NOT NULL, buyer_name VARCHAR(255) NOT NULL, buyer_tax_id VARCHAR(15) NOT NULL, buyer_address VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, due_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, company_address VARCHAR(255) NOT NULL, company_tax_id VARCHAR(15) NOT NULL, default_currency VARCHAR(3) NOT NULL, company_account VARCHAR(40) NOT NULL, default_vat INT NOT NULL, default_due_date_days INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_items ADD CONSTRAINT FK_DCC4B9F8429ECEE2 FOREIGN KEY (invoice_id_id) REFERENCES invoices (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_items DROP FOREIGN KEY FK_DCC4B9F8429ECEE2');
        $this->addSql('DROP TABLE invoice_items');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP TABLE system');
    }
}
