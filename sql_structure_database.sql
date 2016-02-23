-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Gegenereerd op: 23 feb 2016 om 07:25
-- Serverversie: 5.5.46-0ubuntu0.12.04.2
-- PHP-versie: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_archive`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `archive`
--

CREATE TABLE `archive` (
  `YahooMessageID` int(11) NOT NULL DEFAULT '0',
  `FromUser` varchar(255) DEFAULT NULL,
  `FromEmail` varchar(255) DEFAULT NULL,
  `Subject` varchar(255) DEFAULT NULL,
  `SubjectSrt` varchar(255) DEFAULT NULL,
  `RecDate` datetime DEFAULT NULL,
  `Message` mediumtext,
  `AttCount` int(11) DEFAULT NULL,
  `NewMsgFlag` tinyint(1) DEFAULT NULL,
  `DelMsgFlag` tinyint(1) DEFAULT NULL,
  `FavMsgFlag` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`YahooMessageID`);
ALTER TABLE `archive` ADD FULLTEXT KEY `IdxMessage` (`Message`);
ALTER TABLE `archive` ADD FULLTEXT KEY `IdxSubject` (`Subject`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
