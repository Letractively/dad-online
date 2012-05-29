-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2012 at 10:23 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dad`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(8) NOT NULL,
  `user` int(11) NOT NULL,
  `race` int(11) NOT NULL,
  `map` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `user` (`user`),
  KEY `race` (`race`),
  KEY `map` (`map`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `charitems`
--

CREATE TABLE IF NOT EXISTS `charitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `charid` (`charid`),
  KEY `item` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charquestitems`
--

CREATE TABLE IF NOT EXISTS `charquestitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `questitem` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `charid` (`charid`),
  KEY `questitem` (`questitem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charquestmobs`
--

CREATE TABLE IF NOT EXISTS `charquestmobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `questmob` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `charid` (`charid`),
  KEY `questmob` (`questmob`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charquests`
--

CREATE TABLE IF NOT EXISTS `charquests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `quest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `charid` (`charid`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charspells`
--

CREATE TABLE IF NOT EXISTS `charspells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `spell` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `charid` (`charid`),
  KEY `spell` (`spell`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `mapmobs`
--

CREATE TABLE IF NOT EXISTS `mapmobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map` int(11) NOT NULL,
  `mob` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `map` (`map`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `mapnpcs`
--

CREATE TABLE IF NOT EXISTS `mapnpcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map` int(11) NOT NULL,
  `npc` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `map` (`map`),
  KEY `npc` (`npc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `mobs`
--

CREATE TABLE IF NOT EXISTS `mobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `npcquests`
--

CREATE TABLE IF NOT EXISTS `npcquests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `npc` int(11) NOT NULL,
  `quest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `npc` (`npc`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `npcs`
--

CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `questitems`
--

CREATE TABLE IF NOT EXISTS `questitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quest` (`quest`),
  KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `questmobs`
--

CREATE TABLE IF NOT EXISTS `questmobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest` int(11) NOT NULL,
  `mob` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quest` (`quest`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `class` int(11) NOT NULL,
  `startmap` int(11) NOT NULL,
  `startspell` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `startmap` (`startmap`),
  KEY `startspell` (`startspell`),
  KEY `class` (`class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `start` (`start`),
  KEY `end` (`end`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `accesslevel` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`race`) REFERENCES `races` (`id`),
  ADD CONSTRAINT `characters_ibfk_3` FOREIGN KEY (`map`) REFERENCES `maps` (`id`);

--
-- Constraints for table `charitems`
--
ALTER TABLE `charitems`
  ADD CONSTRAINT `charitems_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charitems_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Constraints for table `charquestitems`
--
ALTER TABLE `charquestitems`
  ADD CONSTRAINT `charquestitems_ibfk_2` FOREIGN KEY (`questitem`) REFERENCES `questitems` (`id`),
  ADD CONSTRAINT `charquestitems_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`);

--
-- Constraints for table `charquestmobs`
--
ALTER TABLE `charquestmobs`
  ADD CONSTRAINT `charquestmobs_ibfk_2` FOREIGN KEY (`questmob`) REFERENCES `questmobs` (`id`),
  ADD CONSTRAINT `charquestmobs_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`);

--
-- Constraints for table `charquests`
--
ALTER TABLE `charquests`
  ADD CONSTRAINT `charquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `charquests_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`);

--
-- Constraints for table `charspells`
--
ALTER TABLE `charspells`
  ADD CONSTRAINT `charspells_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Constraints for table `mapmobs`
--
ALTER TABLE `mapmobs`
  ADD CONSTRAINT `mapmobs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapmobs_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`),
  ADD CONSTRAINT `mapmobs_ibfk_3` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Constraints for table `mapnpcs`
--
ALTER TABLE `mapnpcs`
  ADD CONSTRAINT `mapnpcs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapnpcs_ibfk_2` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `mapnpcs_ibfk_3` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`);

--
-- Constraints for table `npcquests`
--
ALTER TABLE `npcquests`
  ADD CONSTRAINT `npcquests_ibfk_1` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `npcquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `npcquests_ibfk_3` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Constraints for table `questitems`
--
ALTER TABLE `questitems`
  ADD CONSTRAINT `questitems_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `questitems_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `questitems_ibfk_3` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Constraints for table `questmobs`
--
ALTER TABLE `questmobs`
  ADD CONSTRAINT `questmobs_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `questmobs_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Constraints for table `races`
--
ALTER TABLE `races`
  ADD CONSTRAINT `races_ibfk_1` FOREIGN KEY (`startmap`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `races_ibfk_2` FOREIGN KEY (`startspell`) REFERENCES `spells` (`id`),
  ADD CONSTRAINT `races_ibfk_8` FOREIGN KEY (`class`) REFERENCES `classes` (`id`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`start`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`end`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `routes_ibfk_3` FOREIGN KEY (`end`) REFERENCES `maps` (`id`);
