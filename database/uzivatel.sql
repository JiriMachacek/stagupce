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