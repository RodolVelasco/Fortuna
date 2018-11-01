<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613055007 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, the_key VARCHAR(255) NOT NULL, the_value LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eventos_institucionales (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nombre_institucion VARCHAR(255) NOT NULL, direccion_responsable_programa LONGTEXT NOT NULL, nombre_programa VARCHAR(255) NOT NULL, nombre_contacto_responsable_programa VARCHAR(255) NOT NULL, telefono_contacto_responsable_programa VARCHAR(15) NOT NULL, email_contacto_responsable_programa VARCHAR(50) NOT NULL, actividad LONGTEXT NOT NULL, departamento VARCHAR(50) NOT NULL, lugar LONGTEXT NOT NULL, fecha DATE NOT NULL, hora INT NOT NULL, minuto INT NOT NULL, poblacion_objetivo LONGTEXT NOT NULL, numero_participantes INT NOT NULL, nombre_contacto_responsable_actividad VARCHAR(50) NOT NULL, telefono_contacto_responsable_actividad VARCHAR(15) NOT NULL, email_contacto_responsable_actividad VARCHAR(50) NOT NULL, INDEX IDX_EF429BF7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metadata (id INT AUTO_INCREMENT NOT NULL, thekey VARCHAR(255) NOT NULL, thevalue VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participa (id INT AUTO_INCREMENT NOT NULL, sorteo_id INT NOT NULL, user_id INT DEFAULT NULL, numero INT NOT NULL, INDEX IDX_E926CCD663FD436 (sorteo_id), INDEX IDX_E926CCDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, cin VARCHAR(255) NOT NULL, cne VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, familyname VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, birthday DATE NOT NULL, birthcity VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, contry VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, etablissement VARCHAR(255) DEFAULT NULL, university VARCHAR(255) DEFAULT NULL, gsm VARCHAR(255) DEFAULT NULL, cnss VARCHAR(255) NOT NULL, cnsstype VARCHAR(255) NOT NULL, parent_name VARCHAR(255) DEFAULT NULL, parent_address VARCHAR(255) DEFAULT NULL, parent_gsm VARCHAR(255) DEFAULT NULL, parent_fixe VARCHAR(255) DEFAULT NULL, ishandicap TINYINT(1) DEFAULT NULL, handicap VARCHAR(255) DEFAULT NULL, needs LONGTEXT DEFAULT NULL, resident TINYINT(1) NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorteo (id INT AUTO_INCREMENT NOT NULL, primera_image_id INT DEFAULT NULL, segunda_image_id INT DEFAULT NULL, tercera_image_id INT DEFAULT NULL, ganador_id INT DEFAULT NULL, creador_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, descripcion VARCHAR(2000) NOT NULL, precio NUMERIC(10, 2) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_ultima_actividad DATETIME NOT NULL, UNIQUE INDEX UNIQ_705F75E02BA5B2FF (primera_image_id), UNIQUE INDEX UNIQ_705F75E0CF401CE9 (segunda_image_id), UNIQUE INDEX UNIQ_705F75E0F39B651C (tercera_image_id), INDEX IDX_705F75E0A338CEA5 (ganador_id), INDEX IDX_705F75E062F40C3D (creador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, image_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, telefono VARCHAR(45) NOT NULL, dui VARCHAR(45) NOT NULL, fecha_nacimiento DATE NOT NULL, sexo TINYINT(1) DEFAULT \'1\' NOT NULL, departamento_municipio VARCHAR(100) DEFAULT NULL, direccion_primaria LONGTEXT DEFAULT NULL, fecha_creacion DATETIME NOT NULL, fecha_ultima_actividad DATETIME NOT NULL, estado TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_8D93D6493DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventos_institucionales ADD CONSTRAINT FK_EF429BF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participa ADD CONSTRAINT FK_E926CCD663FD436 FOREIGN KEY (sorteo_id) REFERENCES sorteo (id)');
        $this->addSql('ALTER TABLE participa ADD CONSTRAINT FK_E926CCDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E02BA5B2FF FOREIGN KEY (primera_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E0CF401CE9 FOREIGN KEY (segunda_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E0F39B651C FOREIGN KEY (tercera_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E0A338CEA5 FOREIGN KEY (ganador_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sorteo ADD CONSTRAINT FK_705F75E062F40C3D FOREIGN KEY (creador_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E02BA5B2FF');
        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E0CF401CE9');
        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E0F39B651C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493DA5256D');
        $this->addSql('ALTER TABLE participa DROP FOREIGN KEY FK_E926CCD663FD436');
        $this->addSql('ALTER TABLE eventos_institucionales DROP FOREIGN KEY FK_EF429BF7A76ED395');
        $this->addSql('ALTER TABLE participa DROP FOREIGN KEY FK_E926CCDA76ED395');
        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E0A338CEA5');
        $this->addSql('ALTER TABLE sorteo DROP FOREIGN KEY FK_705F75E062F40C3D');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE eventos_institucionales');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE metadata');
        $this->addSql('DROP TABLE participa');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE sorteo');
        $this->addSql('DROP TABLE user');
    }
}
