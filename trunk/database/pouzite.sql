/** 
 *	tabulka uzivatel
 */ 
CREATE TABLE uzivatel(
ID_uzivatel Int NOT NULL AUTO_INCREMENT ,
typ Enum( 'student', 'ucitel', 'admin') NOT NULL COMMENT 'student, ucitel, admin',
jmeno Varchar( 50 ) ,
prijmeni Varchar( 50 ) ,
login Varchar( 20 ) NOT NULL ,
heslo Char( 40 ) ,
UNIQUE (login),
PRIMARY KEY ( ID_uzivatel ) 
) ENGINE = InnoDB;



/** 
 *	tabulka novinky
 */ 

Create table novinky (
	ID_novinky Int NOT NULL AUTO_INCREMENT,
	ID_uzivatel Int NOT NULL,
	datum Datetime,
	nazev Varchar(50),
	popis Text,
 Primary Key (ID_novinky,ID_uzivatel)) ENGINE = InnoDB;

/** 
 *	materialy
 */ 
 
 Create table materialy (
	ID_material Int NOT NULL AUTO_INCREMENT,
	ID_uzivatel Int NOT NULL,
	ID_predmet Int NOT NULL,
	popis Text,
	nazev Varchar(50),
	pristupne Datetime,
	upload Datetime,
	velikost Int,
	soubor Varchar(50),
 Primary Key (ID_material,ID_uzivatel,ID_predmet)) ENGINE = InnoDB;