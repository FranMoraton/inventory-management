<?php declare(strict_types = 1);

namespace Inventory\Management\Infrastructure\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502072232 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE size_type');
        $this->addSql('DROP INDEX IDX_F7C0246A20215EEB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__size AS SELECT id, size_type_id, size_value FROM size');
        $this->addSql('DROP TABLE size');
        $this->addSql('CREATE TABLE size (id INTEGER NOT NULL, garment_type_id INTEGER NOT NULL, size_value VARCHAR(3) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_F7C0246AE4AFAD8F FOREIGN KEY (garment_type_id) REFERENCES garment_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO size (id, garment_type_id, size_value) SELECT id, size_type_id, size_value FROM __temp__size');
        $this->addSql('DROP TABLE __temp__size');
        $this->addSql('CREATE INDEX IDX_F7C0246AE4AFAD8F ON size (garment_type_id)');
        $this->addSql('DROP INDEX IDX_E1D67247AE80F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sub_department AS SELECT id, department_id, name FROM sub_department');
        $this->addSql('DROP TABLE sub_department');
        $this->addSql('CREATE TABLE sub_department (id INTEGER NOT NULL, department_id INTEGER NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_E1D67247AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO sub_department (id, department_id, name) SELECT id, department_id, name FROM __temp__sub_department');
        $this->addSql('DROP TABLE __temp__sub_department');
        $this->addSql('CREATE INDEX IDX_E1D67247AE80F5DF ON sub_department (department_id)');
        $this->addSql('DROP INDEX UNIQ_5D9F75A16E6768FF');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1450FF010');
        $this->addSql('DROP INDEX UNIQ_5D9F75A19DADBEC7');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1ADE62BBB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__employee AS SELECT id, employee_status_id, image, nif, name, in_ss_number, telephone, password FROM employee');
        $this->addSql('DROP TABLE employee');
        $this->addSql('CREATE TABLE employee (id INTEGER NOT NULL, employee_status_id INTEGER DEFAULT NULL, image VARCHAR(100) DEFAULT NULL COLLATE BINARY, nif VARCHAR(9) DEFAULT \'-\' NOT NULL COLLATE BINARY, name VARCHAR(50) DEFAULT \'-\' NOT NULL COLLATE BINARY, in_ss_number VARCHAR(30) DEFAULT \'-\' NOT NULL COLLATE BINARY, telephone VARCHAR(12) DEFAULT \'-\' NOT NULL COLLATE BINARY, password VARCHAR(50) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_5D9F75A16E6768FF FOREIGN KEY (employee_status_id) REFERENCES employee_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO employee (id, employee_status_id, image, nif, name, in_ss_number, telephone, password) SELECT id, employee_status_id, image, nif, name, in_ss_number, telephone, password FROM __temp__employee');
        $this->addSql('DROP TABLE __temp__employee');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A16E6768FF ON employee (employee_status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1450FF010 ON employee (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A19DADBEC7 ON employee (in_ss_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1ADE62BBB ON employee (nif)');
        $this->addSql('DROP INDEX IDX_5231A189612D3201');
        $this->addSql('DROP INDEX IDX_5231A189AE80F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__employee_status AS SELECT id, department_id, sub_department_id, first_contract_date, seniority_date, expiration_contract_date, possible_renewal, available_holidays, holidays_pending_to_apply_for FROM employee_status');
        $this->addSql('DROP TABLE employee_status');
        $this->addSql('CREATE TABLE employee_status (id INTEGER NOT NULL, department_id INTEGER DEFAULT NULL, sub_department_id INTEGER DEFAULT NULL, first_contract_date DATETIME NOT NULL, seniority_date DATETIME NOT NULL, expiration_contract_date DATETIME DEFAULT NULL, possible_renewal DATETIME DEFAULT NULL, available_holidays INTEGER DEFAULT 0, holidays_pending_to_apply_for INTEGER DEFAULT 0, PRIMARY KEY(id), CONSTRAINT FK_5231A189AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5231A189612D3201 FOREIGN KEY (sub_department_id) REFERENCES sub_department (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO employee_status (id, department_id, sub_department_id, first_contract_date, seniority_date, expiration_contract_date, possible_renewal, available_holidays, holidays_pending_to_apply_for) SELECT id, department_id, sub_department_id, first_contract_date, seniority_date, expiration_contract_date, possible_renewal, available_holidays, holidays_pending_to_apply_for FROM __temp__employee_status');
        $this->addSql('DROP TABLE __temp__employee_status');
        $this->addSql('CREATE INDEX IDX_5231A189612D3201 ON employee_status (sub_department_id)');
        $this->addSql('CREATE INDEX IDX_5231A189AE80F5DF ON employee_status (department_id)');
        $this->addSql('DROP INDEX IDX_B881175CE4AFAD8F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__garment AS SELECT id, garment_type_id, name FROM garment');
        $this->addSql('DROP TABLE garment');
        $this->addSql('CREATE TABLE garment (id INTEGER NOT NULL, garment_type_id INTEGER NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_B881175CE4AFAD8F FOREIGN KEY (garment_type_id) REFERENCES garment_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO garment (id, garment_type_id, name) SELECT id, garment_type_id, name FROM __temp__garment');
        $this->addSql('DROP TABLE __temp__garment');
        $this->addSql('CREATE INDEX IDX_B881175CE4AFAD8F ON garment (garment_type_id)');
        $this->addSql('DROP INDEX IDX_56234C9A498DA827');
        $this->addSql('DROP INDEX IDX_56234C9A9CDB257C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__garment_size AS SELECT id, garment_id, size_id, stock FROM garment_size');
        $this->addSql('DROP TABLE garment_size');
        $this->addSql('CREATE TABLE garment_size (id INTEGER NOT NULL, garment_id INTEGER NOT NULL, size_id INTEGER NOT NULL, stock INTEGER DEFAULT 0 NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_56234C9A9CDB257C FOREIGN KEY (garment_id) REFERENCES garment (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_56234C9A498DA827 FOREIGN KEY (size_id) REFERENCES size (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO garment_size (id, garment_id, size_id, stock) SELECT id, garment_id, size_id, stock FROM __temp__garment_size');
        $this->addSql('DROP TABLE __temp__garment_size');
        $this->addSql('CREATE INDEX IDX_56234C9A498DA827 ON garment_size (size_id)');
        $this->addSql('CREATE INDEX IDX_56234C9A9CDB257C ON garment_size (garment_id)');
        $this->addSql('DROP INDEX UNIQ_560581FDA7FF5209');
        $this->addSql('CREATE TEMPORARY TABLE __temp__firm AS SELECT id, request_employee_id, url, date_creation FROM firm');
        $this->addSql('DROP TABLE firm');
        $this->addSql('CREATE TABLE firm (id INTEGER NOT NULL, request_employee_id INTEGER DEFAULT NULL, url VARCHAR(75) DEFAULT NULL COLLATE BINARY, date_creation DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_560581FDA7FF5209 FOREIGN KEY (request_employee_id) REFERENCES request_employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO firm (id, request_employee_id, url, date_creation) SELECT id, request_employee_id, url, date_creation FROM __temp__firm');
        $this->addSql('DROP TABLE __temp__firm');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_560581FDA7FF5209 ON firm (request_employee_id)');
        $this->addSql('DROP INDEX IDX_5D4EC0DE686E893B');
        $this->addSql('DROP INDEX IDX_5D4EC0DEA7FF5209');
        $this->addSql('CREATE TEMPORARY TABLE __temp__request_employee_garment AS SELECT id, request_employee_id, garment_size_id FROM request_employee_garment');
        $this->addSql('DROP TABLE request_employee_garment');
        $this->addSql('CREATE TABLE request_employee_garment (id INTEGER NOT NULL, request_employee_id INTEGER NOT NULL, garment_size_id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_5D4EC0DEA7FF5209 FOREIGN KEY (request_employee_id) REFERENCES request_employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5D4EC0DE686E893B FOREIGN KEY (garment_size_id) REFERENCES garment_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO request_employee_garment (id, request_employee_id, garment_size_id) SELECT id, request_employee_id, garment_size_id FROM __temp__request_employee_garment');
        $this->addSql('DROP TABLE __temp__request_employee_garment');
        $this->addSql('CREATE INDEX IDX_5D4EC0DE686E893B ON request_employee_garment (garment_size_id)');
        $this->addSql('CREATE INDEX IDX_5D4EC0DEA7FF5209 ON request_employee_garment (request_employee_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE size_type (id INTEGER NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1ADE62BBB');
        $this->addSql('DROP INDEX UNIQ_5D9F75A19DADBEC7');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1450FF010');
        $this->addSql('DROP INDEX UNIQ_5D9F75A16E6768FF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__employee AS SELECT id, employee_status_id, image, nif, password, name, in_ss_number, telephone FROM employee');
        $this->addSql('DROP TABLE employee');
        $this->addSql('CREATE TABLE employee (id INTEGER NOT NULL, employee_status_id INTEGER DEFAULT NULL, image VARCHAR(100) DEFAULT NULL, nif VARCHAR(9) DEFAULT \'-\' NOT NULL, password VARCHAR(50) NOT NULL, name VARCHAR(50) DEFAULT \'-\' NOT NULL, in_ss_number VARCHAR(30) DEFAULT \'-\' NOT NULL, telephone VARCHAR(12) DEFAULT \'-\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO employee (id, employee_status_id, image, nif, password, name, in_ss_number, telephone) SELECT id, employee_status_id, image, nif, password, name, in_ss_number, telephone FROM __temp__employee');
        $this->addSql('DROP TABLE __temp__employee');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1ADE62BBB ON employee (nif)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A19DADBEC7 ON employee (in_ss_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1450FF010 ON employee (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A16E6768FF ON employee (employee_status_id)');
        $this->addSql('DROP INDEX IDX_5231A189AE80F5DF');
        $this->addSql('DROP INDEX IDX_5231A189612D3201');
        $this->addSql('CREATE TEMPORARY TABLE __temp__employee_status AS SELECT id, department_id, sub_department_id, first_contract_date, seniority_date, expiration_contract_date, possible_renewal, available_holidays, holidays_pending_to_apply_for FROM employee_status');
        $this->addSql('DROP TABLE employee_status');
        $this->addSql('CREATE TABLE employee_status (id INTEGER NOT NULL, department_id INTEGER DEFAULT NULL, sub_department_id INTEGER DEFAULT NULL, first_contract_date DATETIME NOT NULL, seniority_date DATETIME NOT NULL, expiration_contract_date DATETIME DEFAULT NULL, possible_renewal DATETIME DEFAULT NULL, available_holidays INTEGER DEFAULT 0, holidays_pending_to_apply_for INTEGER DEFAULT 0, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO employee_status (id, department_id, sub_department_id, first_contract_date, seniority_date, expiration_contract_date, possible_renewal, available_holidays, holidays_pending_to_apply_for) SELECT id, department_id, sub_department_id, first_contract_date, seniority_date, expiration_contract_date, possible_renewal, available_holidays, holidays_pending_to_apply_for FROM __temp__employee_status');
        $this->addSql('DROP TABLE __temp__employee_status');
        $this->addSql('CREATE INDEX IDX_5231A189AE80F5DF ON employee_status (department_id)');
        $this->addSql('CREATE INDEX IDX_5231A189612D3201 ON employee_status (sub_department_id)');
        $this->addSql('DROP INDEX UNIQ_560581FDA7FF5209');
        $this->addSql('CREATE TEMPORARY TABLE __temp__firm AS SELECT id, request_employee_id, url, date_creation FROM firm');
        $this->addSql('DROP TABLE firm');
        $this->addSql('CREATE TABLE firm (id INTEGER NOT NULL, request_employee_id INTEGER DEFAULT NULL, url VARCHAR(75) DEFAULT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO firm (id, request_employee_id, url, date_creation) SELECT id, request_employee_id, url, date_creation FROM __temp__firm');
        $this->addSql('DROP TABLE __temp__firm');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_560581FDA7FF5209 ON firm (request_employee_id)');
        $this->addSql('DROP INDEX IDX_B881175CE4AFAD8F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__garment AS SELECT id, garment_type_id, name FROM garment');
        $this->addSql('DROP TABLE garment');
        $this->addSql('CREATE TABLE garment (id INTEGER NOT NULL, garment_type_id INTEGER NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO garment (id, garment_type_id, name) SELECT id, garment_type_id, name FROM __temp__garment');
        $this->addSql('DROP TABLE __temp__garment');
        $this->addSql('CREATE INDEX IDX_B881175CE4AFAD8F ON garment (garment_type_id)');
        $this->addSql('DROP INDEX IDX_56234C9A9CDB257C');
        $this->addSql('DROP INDEX IDX_56234C9A498DA827');
        $this->addSql('CREATE TEMPORARY TABLE __temp__garment_size AS SELECT id, garment_id, size_id, stock FROM garment_size');
        $this->addSql('DROP TABLE garment_size');
        $this->addSql('CREATE TABLE garment_size (id INTEGER NOT NULL, garment_id INTEGER NOT NULL, size_id INTEGER NOT NULL, stock INTEGER DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO garment_size (id, garment_id, size_id, stock) SELECT id, garment_id, size_id, stock FROM __temp__garment_size');
        $this->addSql('DROP TABLE __temp__garment_size');
        $this->addSql('CREATE INDEX IDX_56234C9A9CDB257C ON garment_size (garment_id)');
        $this->addSql('CREATE INDEX IDX_56234C9A498DA827 ON garment_size (size_id)');
        $this->addSql('DROP INDEX IDX_5D4EC0DEA7FF5209');
        $this->addSql('DROP INDEX IDX_5D4EC0DE686E893B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__request_employee_garment AS SELECT id, request_employee_id, garment_size_id FROM request_employee_garment');
        $this->addSql('DROP TABLE request_employee_garment');
        $this->addSql('CREATE TABLE request_employee_garment (id INTEGER NOT NULL, request_employee_id INTEGER NOT NULL, garment_size_id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO request_employee_garment (id, request_employee_id, garment_size_id) SELECT id, request_employee_id, garment_size_id FROM __temp__request_employee_garment');
        $this->addSql('DROP TABLE __temp__request_employee_garment');
        $this->addSql('CREATE INDEX IDX_5D4EC0DEA7FF5209 ON request_employee_garment (request_employee_id)');
        $this->addSql('CREATE INDEX IDX_5D4EC0DE686E893B ON request_employee_garment (garment_size_id)');
        $this->addSql('DROP INDEX IDX_F7C0246AE4AFAD8F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__size AS SELECT id, garment_type_id, size_value FROM size');
        $this->addSql('DROP TABLE size');
        $this->addSql('CREATE TABLE size (id INTEGER NOT NULL, size_value VARCHAR(3) NOT NULL, size_type_id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO size (id, size_type_id, size_value) SELECT id, garment_type_id, size_value FROM __temp__size');
        $this->addSql('DROP TABLE __temp__size');
        $this->addSql('CREATE INDEX IDX_F7C0246A20215EEB ON size (size_type_id)');
        $this->addSql('DROP INDEX IDX_E1D67247AE80F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sub_department AS SELECT id, department_id, name FROM sub_department');
        $this->addSql('DROP TABLE sub_department');
        $this->addSql('CREATE TABLE sub_department (id INTEGER NOT NULL, department_id INTEGER NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO sub_department (id, department_id, name) SELECT id, department_id, name FROM __temp__sub_department');
        $this->addSql('DROP TABLE __temp__sub_department');
        $this->addSql('CREATE INDEX IDX_E1D67247AE80F5DF ON sub_department (department_id)');
    }
}
