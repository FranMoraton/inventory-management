<?php declare(strict_types = 1);

namespace Inventory\Management\Infrastructure\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180514095858 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employee_status (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, sub_department_id INT DEFAULT NULL, code_employee INT NOT NULL, first_contract_date DATETIME NOT NULL, seniority_date DATETIME NOT NULL, expiration_contract_date DATETIME DEFAULT NULL, possible_renewal DATETIME DEFAULT NULL, available_holidays INT DEFAULT NULL, holidays_pending_to_apply_for INT DEFAULT NULL, UNIQUE INDEX UNIQ_5231A189A41E0D8A (code_employee), INDEX IDX_5231A189AE80F5DF (department_id), INDEX IDX_5231A189612D3201 (sub_department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, employee_status_id INT DEFAULT NULL, image VARCHAR(100) DEFAULT NULL, nif VARCHAR(9) NOT NULL, password VARCHAR(70) NOT NULL, name VARCHAR(50) NOT NULL, in_ss_number VARCHAR(30) NOT NULL, telephone VARCHAR(12) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1ADE62BBB (nif), UNIQUE INDEX UNIQ_5D9F75A19DADBEC7 (in_ss_number), UNIQUE INDEX UNIQ_5D9F75A1450FF010 (telephone), UNIQUE INDEX UNIQ_5D9F75A16E6768FF (employee_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_CD1DE18A5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_department (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_E1D672475E237E06 (name), INDEX IDX_E1D67247AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garment_size (id INT AUTO_INCREMENT NOT NULL, garment_id INT NOT NULL, size_id INT NOT NULL, stock INT DEFAULT 0 NOT NULL, INDEX IDX_56234C9A9CDB257C (garment_id), INDEX IDX_56234C9A498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, garment_type_id INT NOT NULL, size_value VARCHAR(3) NOT NULL, INDEX IDX_F7C0246AE4AFAD8F (garment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garment (id INT AUTO_INCREMENT NOT NULL, garment_type_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_B881175CE4AFAD8F (garment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE firm (id INT AUTO_INCREMENT NOT NULL, request_employee_id INT DEFAULT NULL, url VARCHAR(75) DEFAULT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_560581FDA7FF5209 (request_employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_employee_garment (id INT AUTO_INCREMENT NOT NULL, request_employee_id INT NOT NULL, garment_size_id INT NOT NULL, INDEX IDX_5D4EC0DEA7FF5209 (request_employee_id), INDEX IDX_5D4EC0DE686E893B (garment_size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_employee (id INT AUTO_INCREMENT NOT NULL, employee INT NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, status VARCHAR(50) DEFAULT \'DRAFT\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee_status ADD CONSTRAINT FK_5231A189AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE employee_status ADD CONSTRAINT FK_5231A189612D3201 FOREIGN KEY (sub_department_id) REFERENCES sub_department (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A16E6768FF FOREIGN KEY (employee_status_id) REFERENCES employee_status (id)');
        $this->addSql('ALTER TABLE sub_department ADD CONSTRAINT FK_E1D67247AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE garment_size ADD CONSTRAINT FK_56234C9A9CDB257C FOREIGN KEY (garment_id) REFERENCES garment (id)');
        $this->addSql('ALTER TABLE garment_size ADD CONSTRAINT FK_56234C9A498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE size ADD CONSTRAINT FK_F7C0246AE4AFAD8F FOREIGN KEY (garment_type_id) REFERENCES garment_type (id)');
        $this->addSql('ALTER TABLE garment ADD CONSTRAINT FK_B881175CE4AFAD8F FOREIGN KEY (garment_type_id) REFERENCES garment_type (id)');
        $this->addSql('ALTER TABLE firm ADD CONSTRAINT FK_560581FDA7FF5209 FOREIGN KEY (request_employee_id) REFERENCES request_employee (id)');
        $this->addSql('ALTER TABLE request_employee_garment ADD CONSTRAINT FK_5D4EC0DEA7FF5209 FOREIGN KEY (request_employee_id) REFERENCES request_employee (id)');
        $this->addSql('ALTER TABLE request_employee_garment ADD CONSTRAINT FK_5D4EC0DE686E893B FOREIGN KEY (garment_size_id) REFERENCES garment_size (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A16E6768FF');
        $this->addSql('ALTER TABLE employee_status DROP FOREIGN KEY FK_5231A189AE80F5DF');
        $this->addSql('ALTER TABLE sub_department DROP FOREIGN KEY FK_E1D67247AE80F5DF');
        $this->addSql('ALTER TABLE employee_status DROP FOREIGN KEY FK_5231A189612D3201');
        $this->addSql('ALTER TABLE request_employee_garment DROP FOREIGN KEY FK_5D4EC0DE686E893B');
        $this->addSql('ALTER TABLE garment_size DROP FOREIGN KEY FK_56234C9A498DA827');
        $this->addSql('ALTER TABLE garment_size DROP FOREIGN KEY FK_56234C9A9CDB257C');
        $this->addSql('ALTER TABLE size DROP FOREIGN KEY FK_F7C0246AE4AFAD8F');
        $this->addSql('ALTER TABLE garment DROP FOREIGN KEY FK_B881175CE4AFAD8F');
        $this->addSql('ALTER TABLE firm DROP FOREIGN KEY FK_560581FDA7FF5209');
        $this->addSql('ALTER TABLE request_employee_garment DROP FOREIGN KEY FK_5D4EC0DEA7FF5209');
        $this->addSql('DROP TABLE employee_status');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE sub_department');
        $this->addSql('DROP TABLE garment_size');
        $this->addSql('DROP TABLE size');
        $this->addSql('DROP TABLE garment');
        $this->addSql('DROP TABLE garment_type');
        $this->addSql('DROP TABLE firm');
        $this->addSql('DROP TABLE request_employee_garment');
        $this->addSql('DROP TABLE request_employee');
    }
}
