/*
Created: 27.12.2008
Modified: 27.12.2008
Project: stagupce
Model: Imported Model
Author: Jiří Macháček
Version: 0.6
Database: MySQL 5.0
*/

-- Create tables section -------------------------------------------------

-- Table ucebna

CREATE TABLE `ucebna`
(
  `ID_ucebna` Int NOT NULL AUTO_INCREMENT,
  `ID_typ` Int NOT NULL,
  `nazev` Varchar(50) NOT NULL,
  `kapacita` Int NOT NULL,
 PRIMARY KEY (`ID_ucebna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

ALTER TABLE `ucebna` ADD UNIQUE `nazev` (`nazev`);

-- Table predmet

CREATE TABLE `predmet`
(
  `ID_predmet` Int NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_garant` Int NOT NULL,
  `nazev` Varchar(50) NOT NULL,
  `prednaska` Enum('ne','ano') NOT NULL
  COMMENT 'ano, ne',
  `pocet_kreditu` Int NOT NULL,
  `zkouska` Enum('ne','ano') NOT NULL
  COMMENT 'ano, ne',
 PRIMARY KEY (`ID_predmet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- Table hodina

CREATE TABLE `hodina`
(
  `ID_hodina` Int NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_vyucujici` Int NOT NULL
  COMMENT 'ucitel',
  `ID_predmet` Int NOT NULL,
  `ID_ucebna` Int NOT NULL,
  `zacatek` Datetime NOT NULL,
  `konec` Datetime NOT NULL,
  `den` Enum('pondeli','utery','streda','ctvrtek','patek','sobota','nedele') NOT NULL
  COMMENT 'pondeli, utery, ... nedele',
  `tyden` Enum('vsechny','lichy','sudy') NOT NULL
  COMMENT 'vsechny, lichy, sudy',
  `kapacita` Int NOT NULL,
 PRIMARY KEY (`ID_hodina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1;

-- Table ucebna_typ

CREATE TABLE `ucebna_typ`
(
  `ID_typ` Int NOT NULL AUTO_INCREMENT,
  `typ` Varchar(50),
 PRIMARY KEY (`ID_typ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1;


-- Table hodina_student

CREATE TABLE `hodina_student`
(
  `ID_hodina` Int NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_student` Int NOT NULL,
PRIMARY KEY (`ID_hodina`,`ID_uzivatel_student`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT;

-- Table page

CREATE TABLE IF NOT EXISTS `page` (
  `ID_page` int(11) NOT NULL AUTO_INCREMENT,
  `modul` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `typ` enum('zobraz','uprav','vloz','vymaz') COLLATE utf8_czech_ci NOT NULL,
  `prava` enum('admin','ucitel','zak','vsichni') COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`ID_page`),
  UNIQUE KEY `modul` (`modul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;


-- Table uzivatel

CREATE TABLE `uzivatel`
(
  `ID_uzivatel` Int NOT NULL AUTO_INCREMENT,
  `typ` Enum('student','ucitel','admin') NOT NULL
  COMMENT 'student, ucitel, admin',
  `jmeno` Varchar(50),
  `prijmeni` Varchar(50),
  `login` Varchar(20) NOT NULL,
  `heslo` Char(40),
 PRIMARY KEY (`ID_uzivatel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

ALTER TABLE `uzivatel` ADD UNIQUE `login` (`login`);

-- Table novinky

CREATE TABLE `novinky`
(
  `ID_novinky` Int NOT NULL AUTO_INCREMENT,
  `ID_uzivatel` Int NOT NULL,
  `datum` Datetime,
  `nazev` Varchar(50),
  `popis` Text,
 PRIMARY KEY (`ID_novinky`,`ID_uzivatel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- Table materialy

CREATE TABLE `materialy`
(
  `ID_material` Int NOT NULL AUTO_INCREMENT,
  `ID_uzivatel` Int NOT NULL,
  `ID_predmet` Int NOT NULL,
  `popis` Text,
  `nazev` Varchar(50),
  `pristupne` Datetime,
  `upload` Datetime,
  `velikost` Int,
  `soubor` Varchar(50),
 PRIMARY KEY (`ID_material`,`ID_uzivatel`,`ID_predmet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- Table zkouska_termin

CREATE TABLE `zkouska_termin`
(
  `ID_zkouska` Int NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_zkousejici` Int NOT NULL,
  `ID_predmet` Int NOT NULL,
  `ID_ucebna` Int NOT NULL,
  `zacatek` Datetime NOT NULL,
  `konec` Datetime NOT NULL,
  `kapacita` Int NOT NULL,
 PRIMARY KEY (`ID_zkouska`,`ID_uzivatel_zkousejici`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- Table zkouska_student

CREATE TABLE `zkouska_student`
(
  `ID_zkouska` Int NOT NULL,
  `ID_uzivatel_zkousejici` Int NOT NULL,
  `ID_uzivatel_zkouseny` Int NOT NULL,
  `pokus` Tinyint NOT NULL,
  `hodnoceni` Tinyint
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT;

ALTER TABLE `zkouska_student` ADD PRIMARY KEY (`ID_zkouska`,`ID_uzivatel_zkousejici`,`ID_uzivatel_zkouseny`);

-- Create relationships section ------------------------------------------------- 

ALTER TABLE `hodina` ADD CONSTRAINT `ucebna_hodina` FOREIGN KEY (`ID_ucebna`) REFERENCES `ucebna` (`ID_ucebna`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `hodina` ADD CONSTRAINT `predmet_hodina` FOREIGN KEY (`ID_predmet`) REFERENCES `predmet` (`ID_predmet`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `materialy` ADD CONSTRAINT `Relationship15` FOREIGN KEY (`ID_predmet`) REFERENCES `predmet` (`ID_predmet`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `hodina_student` ADD CONSTRAINT `student_predmet` FOREIGN KEY (`ID_hodina`) REFERENCES `hodina` (`ID_hodina`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `ucebna` ADD CONSTRAINT `ucebna_typ` FOREIGN KEY (`ID_typ`) REFERENCES `ucebna_typ` (`ID_typ`) ON DELETE RESTRICT ON UPDATE RESTRICT;



ALTER TABLE `predmet` ADD CONSTRAINT `garant_predmetu` FOREIGN KEY (`ID_uzivatel_garant`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `hodina` ADD CONSTRAINT `vyucujici` FOREIGN KEY (`ID_uzivatel_vyucujici`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `hodina_student` ADD CONSTRAINT `student` FOREIGN KEY (`ID_uzivatel_student`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `novinky` ADD CONSTRAINT `novinky` FOREIGN KEY (`ID_uzivatel`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `materialy` ADD CONSTRAINT `Relationship14` FOREIGN KEY (`ID_uzivatel`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `zkouska_termin` ADD CONSTRAINT `Relationship20` FOREIGN KEY (`ID_predmet`) REFERENCES `predmet` (`ID_predmet`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `zkouska_termin` ADD CONSTRAINT `Relationship21` FOREIGN KEY (`ID_ucebna`) REFERENCES `ucebna` (`ID_ucebna`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `zkouska_termin` ADD CONSTRAINT `zkousejici` FOREIGN KEY (`ID_uzivatel_zkousejici`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `zkouska_student` ADD CONSTRAINT `Relationship23` FOREIGN KEY (`ID_zkouska`, `ID_uzivatel_zkousejici`) REFERENCES `zkouska_termin` (`ID_zkouska`, `ID_uzivatel_zkousejici`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `zkouska_student` ADD CONSTRAINT `zkouseny` FOREIGN KEY (`ID_uzivatel_zkouseny`) REFERENCES `uzivatel` (`ID_uzivatel`) ON DELETE NO ACTION ON UPDATE NO ACTION;


