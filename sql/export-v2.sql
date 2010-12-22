-- phpMyAdmin SQL Dump
-- version 3.3.7deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2010 at 06:46 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(1000) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artists_songs`
--

CREATE TABLE IF NOT EXISTS `artists_songs` (
  `artist_id` int(10) unsigned NOT NULL,
  `song_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`song_id`,`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

