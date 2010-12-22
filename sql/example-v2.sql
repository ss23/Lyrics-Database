-- phpMyAdmin SQL Dump
-- version 3.3.7deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2010 at 08:10 PM
-- Server version: 5.0.51
-- PHP Version: 5.3.3-0.dotdeb.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lyricjam`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`) VALUES
(1, 'B.o.B Presents: The Adventures of Bobby Ray'),
(2, 'Spit');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Daft Punk'),
(2, 'Kittie'),
(4, 'Paramore'),
(5, 'B.O.B');

-- --------------------------------------------------------

--
-- Table structure for table `artists_songs`
--

CREATE TABLE IF NOT EXISTS `artists_songs` (
  `artist_id` int(10) unsigned NOT NULL,
  `song_id` int(10) unsigned NOT NULL,
  `relationship_type` enum('Main Contributer','Featured') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`artist_id`,`song_id`),
  KEY `artistrelationship_id` (`relationship_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artists_songs`
--

INSERT INTO `artists_songs` (`artist_id`, `song_id`, `relationship_type`) VALUES
(2, 2, 'Main Contributer'),
(5, 1, 'Main Contributer'),
(4, 1, 'Featured');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `artist_name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `lyrics` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(255)),
  KEY `artist_name` (`artist_name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `artist_name`, `lyrics`) VALUES
(1, 'Airplanes', '<artist>B.O.B</artist> (ft. <artist:Paramore>Hayley Williams from Paramore</artist>)', 'Can we PRETEND THAT LYRICS R HERE kthx'),
(2, 'Raven', '<artist>Kittie</artist>', 'RAWR SCREAMING ANGRY SHITTY VOCALS');

