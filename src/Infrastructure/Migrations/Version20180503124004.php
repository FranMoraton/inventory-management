<?php declare(strict_types = 1);

namespace Inventory\Management\Infrastructure\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180503124004 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD1DE18A5E237E06 ON department (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1D672475E237E06 ON sub_department (name)');
        $this->addSql('ALTER TABLE employee CHANGE nif nif VARCHAR(9) NOT NULL, CHANGE password password VARCHAR(100) NOT NULL, CHANGE name name VARCHAR(50) NOT NULL, CHANGE in_ss_number in_ss_number VARCHAR(30) NOT NULL, CHANGE telephone telephone VARCHAR(12) NOT NULL');
        $this->addSql('ALTER TABLE employee_status ADD code_employee INT NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_CD1DE18A5E237E06 ON department');
        $this->addSql('ALTER TABLE employee CHANGE nif nif VARCHAR(9) DEFAULT \'-\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE password password VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE name name VARCHAR(50) DEFAULT \'-\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE in_ss_number in_ss_number VARCHAR(30) DEFAULT \'-\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE telephone telephone VARCHAR(12) DEFAULT \'-\' NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE employee_status DROP code_employee');
        $this->addSql('DROP INDEX UNIQ_E1D672475E237E06 ON sub_department');
    }
}
