/*
Created: 24.10.2008
Modified: 29.11.2008
Model: MySQL 5.0
Database: MySQL 5.0
*/

-- Create tables section -------------------------------------------------

-- Table api_update

CREATE TABLE `api_update`
(
  `ID_update` Int NOT NULL AUTO_INCREMENT,
  `filename` Char(20) NOT NULL,
  `photos` Int,
  `created` Datetime NOT NULL,
 PRIMARY KEY (`ID_update`)
) ENGINE = InnoDB;

-- Table api_photo

CREATE TABLE `api_photo`
(
  `ID_photo` Int NOT NULL AUTO_INCREMENT,
  `ID_update` Int NOT NULL,
  `ID_restriction` Int
  COMMENT 'ID_poslední testované restrikce',
  `hash` Char(40),
  `Corbis_ID` Varchar(25) NOT NULL,
  `status` Enum('insert', 'update', 'delete') NOT NULL
  COMMENT 'Insert
Update
Delete',
  `avaible` Enum('yes', 'no') NOT NULL,
  `restriction` Text
  COMMENT 'Tady bude text restrikce, generovaný přez tabulku api_restrikce (nejčastější oprava metadat)',
 PRIMARY KEY (`ID_photo`)
) ENGINE = InnoDB;

ALTER TABLE `api_photo` ADD UNIQUE `hash` (`hash`);

-- Table api_agent

CREATE TABLE `api_agent`
(
  `ID_agent` Int NOT NULL AUTO_INCREMENT,
  `ID_zeme` Int NOT NULL,
  `nazev` Varchar(50) NOT NULL,
  `jmeno` Varchar(50) NOT NULL,
  `prijmeni` Varchar(50) NOT NULL,
  `email` Varchar(50),
  `user` Varchar(50)
  COMMENT 'Prihlasovaci jmeno',
  `password` Char(40) NOT NULL,
  `photo_limit` Int NOT NULL
  COMMENT 'maximální počet fotek za den',
 PRIMARY KEY (`ID_agent`)
) ENGINE = InnoDB;

ALTER TABLE `api_agent` ADD UNIQUE `email` (`email`);

ALTER TABLE `api_agent` ADD UNIQUE `user` (`user`);

-- Table api_zeme

CREATE TABLE `api_zeme`
(
  `ID_zeme` Int NOT NULL AUTO_INCREMENT,
  `nazev` Varchar(20) NOT NULL,
 PRIMARY KEY (`ID_zeme`)
) ENGINE = InnoDB;

-- Table api_update_agent

CREATE TABLE `api_update_agent`
(
  `ID_update` Int NOT NULL,
  `ID_agent` Int NOT NULL,
  `first_download` Datetime NOT NULL,
  `last_download` Datetime NOT NULL,
  `num_download` Int NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `api_update_agent` ADD PRIMARY KEY (`ID_update`,`ID_agent`);

-- Table api_restriction

CREATE TABLE `api_restriction`
(
  `ID_restriction` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(100) NOT NULL,
  `rights` Enum('none', 'rm', 'rf') DEFAULT 'none',
  `property` Enum('none', 'yes', 'no') DEFAULT 'none',
  `model` Enum('none', 'yes', 'no') DEFAULT 'none',
  `photographer` Varchar(50),
  `archiv` Int,
  `location` Varchar(150),
  `keywords` Text,
  `description` Text,
  `title` Varchar(100),
  `restrictiontext` Text NOT NULL,
 PRIMARY KEY (`ID_restriction`)
) ENGINE = InnoDB;

-- Table api_restriction_agent

CREATE TABLE `api_restriction_agent`
(
  `ID_agent` Int NOT NULL,
  `ID_restriction` Int NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `api_restriction_agent` ADD PRIMARY KEY (`ID_agent`,`ID_restriction`);

-- Table api_photo_download

CREATE TABLE `api_photo_download`
(
  `ID_download` Int NOT NULL AUTO_INCREMENT,
  `ID_agent` Int NOT NULL,
  `corbis_ID` Varchar(25) NOT NULL,
  `date` Datetime NOT NULL,
 PRIMARY KEY (`ID_download`)
) ENGINE = InnoDB;

-- Table api_ip

CREATE TABLE `api_ip`
(
  `ID_ip` Int NOT NULL AUTO_INCREMENT,
  `ID_agent` Int,
  `ip_v4` Varchar(15),
  `ip_v6` Varchar(39),
 PRIMARY KEY (`ID_ip`)
) ENGINE = InnoDB;

ALTER TABLE `api_ip` ADD UNIQUE `ip_v4` (`ip_v4`);

ALTER TABLE `api_ip` ADD UNIQUE `ip_v6` (`ip_v6`);

-- Table api_photo_restriction

CREATE TABLE `api_photo_restriction`
(
  `ID_photo` Int NOT NULL,
  `ID_restriction` Int NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `api_photo_restriction` ADD PRIMARY KEY (`ID_photo`,`ID_restriction`);

-- Table api_restriction_update

CREATE TABLE `api_restriction_update`
(
  `ID_restriction` Int NOT NULL,
  `type` Enum('new','update','delete') NOT NULL,
  `restrictiontext` Text
) ENGINE = InnoDB;

ALTER TABLE `api_restriction_update` ADD PRIMARY KEY (`ID_restriction`);

-- Create relationships section ------------------------------------------------- 

ALTER TABLE `api_agent` ADD CONSTRAINT `api_rel_1` FOREIGN KEY (`ID_zeme`) REFERENCES `api_zeme` (`ID_zeme`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_update_agent` ADD CONSTRAINT `api_rel_5` FOREIGN KEY (`ID_agent`) REFERENCES `api_agent` (`ID_agent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_update_agent` ADD CONSTRAINT `api_rel_7` FOREIGN KEY (`ID_update`) REFERENCES `api_update` (`ID_update`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_photo` ADD CONSTRAINT `api_rel_8` FOREIGN KEY (`ID_update`) REFERENCES `api_update` (`ID_update`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_restriction_agent` ADD CONSTRAINT `api_rel_4` FOREIGN KEY (`ID_agent`) REFERENCES `api_agent` (`ID_agent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_restriction_agent` ADD CONSTRAINT `api_rel_6` FOREIGN KEY (`ID_restriction`) REFERENCES `api_restriction` (`ID_restriction`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_photo_download` ADD CONSTRAINT `api_rel_3` FOREIGN KEY (`ID_agent`) REFERENCES `api_agent` (`ID_agent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_ip` ADD CONSTRAINT `api_rel_2` FOREIGN KEY (`ID_agent`) REFERENCES `api_agent` (`ID_agent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_photo_restriction` ADD CONSTRAINT `api_rel_9` FOREIGN KEY (`ID_photo`) REFERENCES `api_photo` (`ID_photo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_photo_restriction` ADD CONSTRAINT `api_rel_10` FOREIGN KEY (`ID_restriction`) REFERENCES `api_restriction` (`ID_restriction`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_photo` ADD CONSTRAINT `api_rel_11` FOREIGN KEY (`ID_restriction`) REFERENCES `api_restriction` (`ID_restriction`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `api_restriction_update` ADD CONSTRAINT `spi_rel_12` FOREIGN KEY (`ID_restriction`) REFERENCES `api_restriction` (`ID_restriction`) ON DELETE NO ACTION ON UPDATE NO ACTION;


