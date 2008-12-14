/*
Created		11.12.2008
Modified		12.12.2008
Project		stagupce
Model		
Company		
Author		Jiøí Macháèek
Version		0.2
Database		mySQL 5 
*/




Create table ucebna (
	ID_ucebna Int NOT NULL AUTO_INCREMENT,
	ID_typ Int NOT NULL,
	nazev Varchar(50) NOT NULL,
	kapacita Int NOT NULL,
	UNIQUE (nazev),
 Primary Key (ID_ucebna)) ENGINE = InnoDB;

Create table student (
	ID_student Int NOT NULL AUTO_INCREMENT,
	jmeno Varchar(50) NOT NULL,
	prijmeni Varchar(50),
 Primary Key (ID_student)) ENGINE = InnoDB;

Create table predmet (
	ID_predmet Int NOT NULL AUTO_INCREMENT,
	ID_ucitel Int NOT NULL,
	nazev Varchar(50) NOT NULL,
	prednaska Enum('ne', 'ano') NOT NULL COMMENT 'ano, ne',
 Primary Key (ID_predmet)) ENGINE = InnoDB;

Create table ucitel (
	ID_ucitel Int NOT NULL AUTO_INCREMENT,
	jmeno Varchar(50),
	prijmeni Varchar(50),
 Primary Key (ID_ucitel)) ENGINE = InnoDB;

Create table hodina (
	ID_hodina Int NOT NULL AUTO_INCREMENT,
	ID_semestr Int NOT NULL,
	ID_ucitel Int NOT NULL,
	ID_predmet Int NOT NULL,
	ID_ucebna Int NOT NULL,
	zacatek Datetime NOT NULL,
	konec Datetime NOT NULL,
	den Enum('pondeli', 'utery', 'streda', 'ctvrtek', 'patek', 'sobota', 'nedele') NOT NULL COMMENT 'pondeli, utery, ... nedele',
	tyden Varchar(20) NOT NULL COMMENT 'lichy, sudy',
 Primary Key (ID_hodina)) ENGINE = InnoDB;

Create table trida_typ (
	ID_typ Int NOT NULL,
	typ Varchar(50),
 Primary Key (ID_typ)) ENGINE = InnoDB;

Create table hodina_student (
	ID_hodina Int NOT NULL,
	ID_student Int NOT NULL,
 Primary Key (ID_hodina,ID_student)) ENGINE = InnoDB;

Create table semestr (
	ID_semestr Int NOT NULL AUTO_INCREMENT,
	zacetek Date,
	konec Date,
	typ Enum('letni', 'zimni') COMMENT 'letni, zimni',
 Primary Key (ID_semestr)) ENGINE = InnoDB;

Create table page (
	ID_page Int NOT NULL AUTO_INCREMENT,
	modul Varchar(50),
	role Enum('ucitel', 'student', 'admin'),
	UNIQUE (modul),
 Primary Key (ID_page)) ENGINE = InnoDB;






Alter table hodina add Foreign Key (ID_ucebna) references ucebna (ID_ucebna) on delete  restrict on update  restrict;
Alter table hodina_student add Foreign Key (ID_student) references student (ID_student) on delete  restrict on update  restrict;
Alter table hodina add Foreign Key (ID_predmet) references predmet (ID_predmet) on delete  restrict on update  restrict;
Alter table predmet add Foreign Key (ID_ucitel) references ucitel (ID_ucitel) on delete  restrict on update  restrict;
Alter table hodina add Foreign Key (ID_ucitel) references ucitel (ID_ucitel) on delete  restrict on update  restrict;
Alter table hodina_student add Foreign Key (ID_hodina) references hodina (ID_hodina) on delete  restrict on update  restrict;
Alter table ucebna add Foreign Key (ID_typ) references trida_typ (ID_typ) on delete  restrict on update  restrict;
Alter table hodina add Foreign Key (ID_semestr) references semestr (ID_semestr) on delete  restrict on update  restrict;






