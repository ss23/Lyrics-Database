-- phpMyAdmin SQL Dump
-- version 3.3.7deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2010 at 10:58 PM
-- Server version: 5.0.51
-- PHP Version: 5.3.3-0.dotdeb.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lyricjam`
--

-- --------------------------------------------------------

--
-- Table structure for table `albumrelationships`
--

CREATE TABLE IF NOT EXISTS `albumrelationships` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(200) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `albums_albumrelationships`
--

CREATE TABLE IF NOT EXISTS `albums_albumrelationships` (
  `type` int(10) unsigned NOT NULL,
  `album_id` int(10) unsigned NOT NULL,
  `value` varchar(1000) collate utf8_unicode_ci NOT NULL,
  KEY `type` (`type`,`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artistrelationships`
--

CREATE TABLE IF NOT EXISTS `artistrelationships` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `artists_artistrelationships`
--

CREATE TABLE IF NOT EXISTS `artists_artistrelationships` (
  `type` int(10) unsigned NOT NULL,
  `artist_id` int(10) unsigned NOT NULL,
  `value` varchar(1000) collate utf8_unicode_ci NOT NULL,
  KEY `type` (`type`,`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `artist_id` int(10) unsigned NOT NULL,
  `name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  `lyrics` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `artist_id` (`artist_id`,`name`(200))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums_albumrelationships`
--
ALTER TABLE `albums_albumrelationships`
  ADD CONSTRAINT `albums_albumrelationships_ibfk_1` FOREIGN KEY (`type`) REFERENCES `albumrelationships` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `artists_artistrelationships`
--
ALTER TABLE `artists_artistrelationships`
  ADD CONSTRAINT `artists_artistrelationships_ibfk_1` FOREIGN KEY (`type`) REFERENCES `artistrelationships` (`id`) ON DELETE CASCADE;

