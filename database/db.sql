-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pátek 16. ledna 2009, 12:19
-- Verze MySQL: 5.1.30
-- Verze PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `stagupce`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `hodina`
--

CREATE TABLE IF NOT EXISTS `hodina` (
  `ID_hodina` int(11) NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_vyucujici` int(11) NOT NULL COMMENT 'ucitel',
  `ID_semestr` int(11) NOT NULL,
  `ID_predmet` int(11) NOT NULL,
  `ID_ucebna` int(11) NOT NULL,
  `zacatek` datetime NOT NULL,
  `konec` datetime NOT NULL,
  `den` enum('pondělí','úterý','středa','čtvrtek','pátek','sobota','neděle') COLLATE utf8_czech_ci NOT NULL COMMENT 'pondeli, utery, ... nedele',
  `tyden` enum('všechny','lichý','sudý') COLLATE utf8_czech_ci NOT NULL COMMENT 'vsechny, lichy, sudy',
  `kapacita` int(11) NOT NULL,
  PRIMARY KEY (`ID_hodina`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `hodina`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `hodina_student`
--

CREATE TABLE IF NOT EXISTS `hodina_student` (
  `ID_hodina` int(11) NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_student` int(11) NOT NULL,
  PRIMARY KEY (`ID_hodina`,`ID_uzivatel_student`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `hodina_student`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `materialy`
--

CREATE TABLE IF NOT EXISTS `materialy` (
  `ID_material` int(11) NOT NULL AUTO_INCREMENT,
  `ID_uzivatel` int(11) NOT NULL,
  `ID_predmet` int(11) NOT NULL,
  `popis` text COLLATE utf8_czech_ci,
  `nazev` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `pristupne` datetime DEFAULT NULL,
  `upload` datetime DEFAULT NULL,
  `velikost` int(11) DEFAULT NULL,
  `soubor` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`ID_material`,`ID_uzivatel`,`ID_predmet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `materialy`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `novinky`
--

CREATE TABLE IF NOT EXISTS `novinky` (
  `ID_novinky` int(11) NOT NULL AUTO_INCREMENT,
  `ID_uzivatel` int(11) NOT NULL,
  `datum` datetime DEFAULT NULL,
  `nazev` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `popis` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`ID_novinky`,`ID_uzivatel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `novinky`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `ID_page` int(11) NOT NULL AUTO_INCREMENT,
  `modul` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `typ` enum('zobraz','uprav','vloz','vymaz') COLLATE utf8_czech_ci NOT NULL,
  `prava` enum('admin','ucitel','zak','vsichni') COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`ID_page`),
  UNIQUE KEY `modul` (`modul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `page`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `predmet`
--

CREATE TABLE IF NOT EXISTS `predmet` (
  `ID_predmet` int(11) NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_garant` int(11) NOT NULL,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `prednaska` enum('ne','ano') COLLATE utf8_czech_ci NOT NULL COMMENT 'ano, ne',
  `pocet_kreditu` int(11) NOT NULL,
  `zkouska` enum('ne','ano') COLLATE utf8_czech_ci NOT NULL COMMENT 'ano, ne',
  PRIMARY KEY (`ID_predmet`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `predmet`
--

INSERT INTO `predmet` (`ID_predmet`, `ID_uzivatel_garant`, `nazev`, `prednaska`, `pocet_kreditu`, `zkouska`) VALUES
(1, 2, 'OOP', 'ne', 6, 'ano'),
(2, 3, 'Pascal', 'ano', 2, 'ne');

-- --------------------------------------------------------

--
-- Struktura tabulky `semestr`
--

CREATE TABLE IF NOT EXISTS `semestr` (
  `ID_semestr` int(11) NOT NULL AUTO_INCREMENT,
  `zacetek` date DEFAULT NULL,
  `konec` date DEFAULT NULL,
  `typ` enum('letní','zimní') COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'letni, zimni',
  PRIMARY KEY (`ID_semestr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `semestr`
--

INSERT INTO `semestr` (`ID_semestr`, `zacetek`, `konec`, `typ`) VALUES
(1, '2008-10-01', '2009-02-28', 'letní');

-- --------------------------------------------------------

--
-- Struktura tabulky `ucebna`
--

CREATE TABLE IF NOT EXISTS `ucebna` (
  `ID_ucebna` int(11) NOT NULL AUTO_INCREMENT,
  `ID_typ` int(11) NOT NULL,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `kapacita` int(11) NOT NULL,
  PRIMARY KEY (`ID_ucebna`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `ucebna`
--

INSERT INTO `ucebna` (`ID_ucebna`, `ID_typ`, `nazev`, `kapacita`) VALUES
(4, 2, 'vlesiku', 30),
(3, 1, 'dv101', 50),
(5, 1, 'dv102', 40),
(6, 3, 'A1', 1000),
(7, 4, 'A2', 10);

-- --------------------------------------------------------

--
-- Struktura tabulky `ucebna_typ`
--

CREATE TABLE IF NOT EXISTS `ucebna_typ` (
  `ID_typ` int(11) NOT NULL AUTO_INCREMENT,
  `typ` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`ID_typ`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `ucebna_typ`
--

INSERT INTO `ucebna_typ` (`ID_typ`, `typ`) VALUES
(1, 'počítačová'),
(2, 'venkovní'),
(3, 'aula'),
(4, 'chemická labolatoř');

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE IF NOT EXISTS `uzivatel` (
  `ID_uzivatel` int(11) NOT NULL AUTO_INCREMENT,
  `typ` enum('student','učitel','admin') COLLATE utf8_czech_ci NOT NULL COMMENT 'student, ucitel, admin',
  `jmeno` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `prijmeni` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `login` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `heslo` char(40) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`ID_uzivatel`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`ID_uzivatel`, `typ`, `jmeno`, `prijmeni`, `login`, `heslo`) VALUES
(1, 'admin', 'jhk', NULL, 'luke', 'heslo'),
(2, 'učitel', 'Lukáš', 'Slánský', 'lukas', 'slansky'),
(3, 'učitel', 'Josef', 'Rak', 'josef', 'rak');

-- --------------------------------------------------------

--
-- Struktura tabulky `zkouska_student`
--

CREATE TABLE IF NOT EXISTS `zkouska_student` (
  `ID_zkouska` int(11) NOT NULL,
  `ID_uzivatel_zkousejici` int(11) NOT NULL,
  `ID_uzivatel_zkouseny` int(11) NOT NULL,
  `pokus` tinyint(4) NOT NULL,
  `hodnoceni` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`ID_zkouska`,`ID_uzivatel_zkousejici`,`ID_uzivatel_zkouseny`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `zkouska_student`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `zkouska_termin`
--

CREATE TABLE IF NOT EXISTS `zkouska_termin` (
  `ID_zkouska` int(11) NOT NULL AUTO_INCREMENT,
  `ID_uzivatel_zkousejici` int(11) NOT NULL,
  `ID_predmet` int(11) NOT NULL,
  `ID_ucebna` int(11) NOT NULL,
  `zacatek` datetime NOT NULL,
  `konec` datetime NOT NULL,
  `kapacita` int(11) NOT NULL,
  PRIMARY KEY (`ID_zkouska`,`ID_uzivatel_zkousejici`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `zkouska_termin`
--

