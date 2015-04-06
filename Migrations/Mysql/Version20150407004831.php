<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Create the first migration file for default database!
 */
class Version20150407004831 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE flow_box_domain_model_content (persistence_object_identifier VARCHAR(40) NOT NULL, femenu VARCHAR(40) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_8F46BF0062FC5056 (femenu), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE flow_box_domain_model_femenu (persistence_object_identifier VARCHAR(40) NOT NULL, parentmenu VARCHAR(40) DEFAULT NULL, childrenmenu VARCHAR(40) DEFAULT NULL, name VARCHAR(255) NOT NULL, sysvalue VARCHAR(255) NOT NULL, menuorder INT NOT NULL, UNIQUE INDEX UNIQ_50F67012604313CD (menuorder), INDEX IDX_50F67012BCD400C (parentmenu), INDEX IDX_50F6701254878FE9 (childrenmenu), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE flow_box_domain_model_label (persistence_object_identifier VARCHAR(40) NOT NULL, labelname VARCHAR(255) NOT NULL, syskey VARCHAR(255) NOT NULL, sysvalue LONGTEXT NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE flow_box_domain_model_page (persistence_object_identifier VARCHAR(40) NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) NOT NULL, publishdate DATETIME NOT NULL, expiredate DATETIME NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE flow_box_domain_model_user (persistence_object_identifier VARCHAR(40) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("ALTER TABLE flow_box_domain_model_content ADD CONSTRAINT FK_8F46BF0062FC5056 FOREIGN KEY (femenu) REFERENCES flow_box_domain_model_femenu (persistence_object_identifier)");
		$this->addSql("ALTER TABLE flow_box_domain_model_femenu ADD CONSTRAINT FK_50F67012BCD400C FOREIGN KEY (parentmenu) REFERENCES flow_box_domain_model_femenu (persistence_object_identifier)");
		$this->addSql("ALTER TABLE flow_box_domain_model_femenu ADD CONSTRAINT FK_50F6701254878FE9 FOREIGN KEY (childrenmenu) REFERENCES flow_box_domain_model_femenu (persistence_object_identifier)");
		$this->addSql("ALTER TABLE flow_box_domain_model_user ADD CONSTRAINT FK_CCB1076F47A46B0A FOREIGN KEY (persistence_object_identifier) REFERENCES typo3_party_domain_model_abstractparty (persistence_object_identifier) ON DELETE CASCADE");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE flow_box_domain_model_content DROP FOREIGN KEY FK_8F46BF0062FC5056");
		$this->addSql("ALTER TABLE flow_box_domain_model_femenu DROP FOREIGN KEY FK_50F67012BCD400C");
		$this->addSql("ALTER TABLE flow_box_domain_model_femenu DROP FOREIGN KEY FK_50F6701254878FE9");
		$this->addSql("DROP TABLE ext_translations");
		$this->addSql("DROP TABLE flow_box_domain_model_content");
		$this->addSql("DROP TABLE flow_box_domain_model_femenu");
		$this->addSql("DROP TABLE flow_box_domain_model_label");
		$this->addSql("DROP TABLE flow_box_domain_model_page");
		$this->addSql("DROP TABLE flow_box_domain_model_user");
	}
}