-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2012 at 08:25 PM
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
-- Table structure for table `battlenpcs`
--

DROP TABLE IF EXISTS `battlenpcs`;
CREATE TABLE IF NOT EXISTS `battlenpcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `npc` int(10) unsigned NOT NULL,
  `hp` tinyint(3) unsigned NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid` (`charid`),
  KEY `npc` (`npc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `battlenpcs`
--
DROP TRIGGER IF EXISTS `npcmaxhp`;
DELIMITER //
CREATE TRIGGER `npcmaxhp` BEFORE UPDATE ON `battlenpcs`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `npcmaxhpinsert`;
DELIMITER //
CREATE TRIGGER `npcmaxhpinsert` BEFORE INSERT ON `battlenpcs`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `battles`
--

DROP TABLE IF EXISTS `battles`;
CREATE TABLE IF NOT EXISTS `battles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `mob` int(10) unsigned NOT NULL,
  `hp` tinyint(3) unsigned NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid` (`charid`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `battles`
--
DROP TRIGGER IF EXISTS `mobmaxhp`;
DELIMITER //
CREATE TRIGGER `mobmaxhp` BEFORE UPDATE ON `battles`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `mobmaxhpinsert`;
DELIMITER //
CREATE TRIGGER `mobmaxhpinsert` BEFORE INSERT ON `battles`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `questmobs_tracker`;
DELIMITER //
CREATE TRIGGER `questmobs_tracker` BEFORE DELETE ON `battles`
 FOR EACH ROW begin
UPDATE charquestmobs SET amount = amount+1 WHERE charid = old.charid AND questmob in (SELECT id FROM questmobs WHERE mob = old.mob);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

DROP TABLE IF EXISTS `characters`;
CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(8) NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `race` int(10) unsigned NOT NULL,
  `map` int(10) unsigned NOT NULL,
  `hp` tinyint(3) unsigned NOT NULL DEFAULT '100',
  `alignment` tinyint(4) NOT NULL,
  `str` smallint(5) unsigned NOT NULL,
  `int` smallint(5) unsigned NOT NULL,
  `agi` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `user` (`user`),
  KEY `race` (`race`),
  KEY `map` (`map`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Triggers `characters`
--
DROP TRIGGER IF EXISTS `maxhp`;
DELIMITER //
CREATE TRIGGER `maxhp` BEFORE UPDATE ON `characters`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `maxhpinsert`;
DELIMITER //
CREATE TRIGGER `maxhpinsert` BEFORE INSERT ON `characters`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `startspells`;
DELIMITER //
CREATE TRIGGER `startspells` AFTER INSERT ON `characters`
 FOR EACH ROW begin
INSERT INTO charspells SET charid = (SELECT id FROM characters WHERE name = new.name),
spell = (SELECT startspell FROM races WHERE id = new.race);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `charitems`
--

DROP TABLE IF EXISTS `charitems`;
CREATE TABLE IF NOT EXISTS `charitems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `item` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`item`),
  KEY `charid` (`charid`),
  KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `charquestmobs`
--

DROP TABLE IF EXISTS `charquestmobs`;
CREATE TABLE IF NOT EXISTS `charquestmobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `questmob` int(10) unsigned NOT NULL,
  `amount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`questmob`),
  KEY `charid` (`charid`),
  KEY `questmob` (`questmob`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charquests`
--

DROP TABLE IF EXISTS `charquests`;
CREATE TABLE IF NOT EXISTS `charquests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `quest` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`quest`),
  KEY `charid` (`charid`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `charquests`
--
DROP TRIGGER IF EXISTS `startquests`;
DELIMITER //
CREATE TRIGGER `startquests` BEFORE INSERT ON `charquests`
 FOR EACH ROW begin
INSERT INTO charquestmobs (charid,questmob)
SELECT new.charid,id FROM questmobs WHERE quest = new.quest;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `charspells`
--

DROP TABLE IF EXISTS `charspells`;
CREATE TABLE IF NOT EXISTS `charspells` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `spell` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`spell`),
  KEY `charid` (`charid`),
  KEY `spell` (`spell`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `accesslevel` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `completequests`
--

DROP TABLE IF EXISTS `completequests`;
CREATE TABLE IF NOT EXISTS `completequests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charid` int(10) unsigned NOT NULL,
  `quest` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`quest`),
  KEY `charid` (`charid`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Triggers `completequests`
--
DROP TRIGGER IF EXISTS `movequests`;
DELIMITER //
CREATE TRIGGER `movequests` BEFORE INSERT ON `completequests`
 FOR EACH ROW begin
DELETE FROM charquests 
WHERE charquests.charid = new.charid
AND charquests.quest = new.quest;
DELETE FROM charquestmobs
WHERE charquestmobs.charid = new.charid
AND charquestmobs.questmob in 
	(SELECT id FROM questmobs
	WHERE quest = new.quest);
UPDATE characters SET alignment = alignment + (SELECT changealignment FROM quests WHERE id = new.quest) WHERE id = new.charid;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `drops`
--

DROP TABLE IF EXISTS `drops`;
CREATE TABLE IF NOT EXISTS `drops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mob` int(10) unsigned NOT NULL,
  `item` int(10) unsigned NOT NULL,
  `rate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `max` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mob_2` (`mob`,`item`),
  KEY `mob` (`mob`),
  KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Triggers `drops`
--
DROP TRIGGER IF EXISTS `maxrate`;
DELIMITER //
CREATE TRIGGER `maxrate` BEFORE UPDATE ON `drops`
 FOR EACH ROW begin if new.rate > 100 then set new.rate = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `maxrateinsert`;
DELIMITER //
CREATE TRIGGER `maxrateinsert` BEFORE INSERT ON `drops`
 FOR EACH ROW begin if new.rate > 100 then set new.rate = 100; end if; end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapmobs`
--

DROP TABLE IF EXISTS `mapmobs`;
CREATE TABLE IF NOT EXISTS `mapmobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `map` int(10) unsigned NOT NULL,
  `mob` int(10) unsigned NOT NULL,
  `rate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `map_2` (`map`,`mob`),
  KEY `map` (`map`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapnpcs`
--

DROP TABLE IF EXISTS `mapnpcs`;
CREATE TABLE IF NOT EXISTS `mapnpcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `map` int(10) unsigned NOT NULL,
  `npc` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `map_2` (`map`,`npc`),
  KEY `map` (`map`),
  KEY `npc` (`npc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

DROP TABLE IF EXISTS `maps`;
CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mobs`
--

DROP TABLE IF EXISTS `mobs`;
CREATE TABLE IF NOT EXISTS `mobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `str` smallint(5) unsigned NOT NULL,
  `int` smallint(5) unsigned NOT NULL,
  `agi` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Triggers `mobs`
--
DROP TRIGGER IF EXISTS `mobstartspells`;
DELIMITER //
CREATE TRIGGER `mobstartspells` AFTER INSERT ON `mobs`
 FOR EACH ROW begin
INSERT INTO mobspells SET mob = (SELECT id FROM mobs WHERE name = new.name),
spell = (SELECT startspell FROM mobtypes WHERE id = new.type);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mobspells`
--

DROP TABLE IF EXISTS `mobspells`;
CREATE TABLE IF NOT EXISTS `mobspells` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mob` int(10) unsigned NOT NULL,
  `spell` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mob_2` (`mob`,`spell`),
  KEY `mob` (`mob`),
  KEY `spell` (`spell`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mobtypes`
--

DROP TABLE IF EXISTS `mobtypes`;
CREATE TABLE IF NOT EXISTS `mobtypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `startspell` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `startspell` (`startspell`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npcquests`
--

DROP TABLE IF EXISTS `npcquests`;
CREATE TABLE IF NOT EXISTS `npcquests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `npc` int(10) unsigned NOT NULL,
  `quest` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `npc_2` (`npc`,`quest`),
  KEY `npc` (`npc`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npcs`
--

DROP TABLE IF EXISTS `npcs`;
CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `race` int(10) unsigned NOT NULL,
  `alignment` tinyint(4) NOT NULL,
  `str` smallint(5) unsigned NOT NULL,
  `int` smallint(5) unsigned NOT NULL,
  `agi` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `race` (`race`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Triggers `npcs`
--
DROP TRIGGER IF EXISTS `npcstartspells`;
DELIMITER //
CREATE TRIGGER `npcstartspells` AFTER INSERT ON `npcs`
 FOR EACH ROW begin
INSERT INTO npcspells SET npc = (SELECT id FROM npcs WHERE name = new.name),
spell = (SELECT startspell FROM races WHERE id = new.race);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `npcspells`
--

DROP TABLE IF EXISTS `npcspells`;
CREATE TABLE IF NOT EXISTS `npcspells` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `npc` int(10) unsigned NOT NULL,
  `spell` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `npc_2` (`npc`,`spell`),
  KEY `npc` (`npc`),
  KEY `spell` (`spell`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questitems`
--

DROP TABLE IF EXISTS `questitems`;
CREATE TABLE IF NOT EXISTS `questitems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quest` int(10) unsigned NOT NULL,
  `item` int(10) unsigned NOT NULL,
  `amount` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `quest_2` (`quest`,`item`),
  KEY `quest` (`quest`),
  KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questmobs`
--

DROP TABLE IF EXISTS `questmobs`;
CREATE TABLE IF NOT EXISTS `questmobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quest` int(10) unsigned NOT NULL,
  `mob` int(10) unsigned NOT NULL,
  `amount` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `quest_2` (`quest`,`mob`),
  KEY `quest` (`quest`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

DROP TABLE IF EXISTS `quests`;
CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `changealignment` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

DROP TABLE IF EXISTS `races`;
CREATE TABLE IF NOT EXISTS `races` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `class` int(10) unsigned NOT NULL,
  `startmap` int(10) unsigned NOT NULL,
  `startspell` int(10) unsigned NOT NULL,
  `startalignment` tinyint(4) NOT NULL,
  `startstr` smallint(5) unsigned NOT NULL,
  `startint` smallint(5) unsigned NOT NULL,
  `startagi` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `startmap` (`startmap`),
  KEY `startspell` (`startspell`),
  KEY `class` (`class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

DROP TABLE IF EXISTS `rewards`;
CREATE TABLE IF NOT EXISTS `rewards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quest` int(10) unsigned NOT NULL,
  `item` int(10) unsigned NOT NULL,
  `amount` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `quest_2` (`quest`,`item`),
  KEY `quest` (`quest`),
  KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `routerequirements`
--

DROP TABLE IF EXISTS `routerequirements`;
CREATE TABLE IF NOT EXISTS `routerequirements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `route` int(10) unsigned NOT NULL,
  `quest` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `route_2` (`route`,`quest`),
  KEY `charid` (`route`),
  KEY `questmob` (`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start` int(10) unsigned NOT NULL,
  `end` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `start_2` (`start`,`end`),
  KEY `start` (`start`),
  KEY `end` (`end`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

DROP TABLE IF EXISTS `spells`;
CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `str` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `int` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `agi` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `accesslevel` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `battlenpcs`
--
ALTER TABLE `battlenpcs`
  ADD CONSTRAINT `battlenpcs_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `battlenpcs_ibfk_2` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`);

--
-- Constraints for table `battles`
--
ALTER TABLE `battles`
  ADD CONSTRAINT `battles_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `battles_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

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
-- Constraints for table `charquestmobs`
--
ALTER TABLE `charquestmobs`
  ADD CONSTRAINT `charquestmobs_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charquestmobs_ibfk_2` FOREIGN KEY (`questmob`) REFERENCES `questmobs` (`id`);

--
-- Constraints for table `charquests`
--
ALTER TABLE `charquests`
  ADD CONSTRAINT `charquests_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Constraints for table `charspells`
--
ALTER TABLE `charspells`
  ADD CONSTRAINT `charspells_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Constraints for table `completequests`
--
ALTER TABLE `completequests`
  ADD CONSTRAINT `completequests_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `completequests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Constraints for table `drops`
--
ALTER TABLE `drops`
  ADD CONSTRAINT `drops_ibfk_1` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`),
  ADD CONSTRAINT `drops_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Constraints for table `mapmobs`
--
ALTER TABLE `mapmobs`
  ADD CONSTRAINT `mapmobs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapmobs_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Constraints for table `mapnpcs`
--
ALTER TABLE `mapnpcs`
  ADD CONSTRAINT `mapnpcs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapnpcs_ibfk_2` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`);

--
-- Constraints for table `mobs`
--
ALTER TABLE `mobs`
  ADD CONSTRAINT `mobs_ibfk_1` FOREIGN KEY (`type`) REFERENCES `mobtypes` (`id`);

--
-- Constraints for table `mobspells`
--
ALTER TABLE `mobspells`
  ADD CONSTRAINT `mobspells_ibfk_1` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`),
  ADD CONSTRAINT `mobspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Constraints for table `mobtypes`
--
ALTER TABLE `mobtypes`
  ADD CONSTRAINT `mobtypes_ibfk_1` FOREIGN KEY (`startspell`) REFERENCES `spells` (`id`);

--
-- Constraints for table `npcquests`
--
ALTER TABLE `npcquests`
  ADD CONSTRAINT `npcquests_ibfk_1` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `npcquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Constraints for table `npcs`
--
ALTER TABLE `npcs`
  ADD CONSTRAINT `npcs_ibfk_1` FOREIGN KEY (`race`) REFERENCES `races` (`id`);

--
-- Constraints for table `npcspells`
--
ALTER TABLE `npcspells`
  ADD CONSTRAINT `npcspells_ibfk_1` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `npcspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Constraints for table `questitems`
--
ALTER TABLE `questitems`
  ADD CONSTRAINT `questitems_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `questitems_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

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
  ADD CONSTRAINT `races_ibfk_3` FOREIGN KEY (`class`) REFERENCES `classes` (`id`);

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `rewards_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Constraints for table `routerequirements`
--
ALTER TABLE `routerequirements`
  ADD CONSTRAINT `routerequirements_ibfk_1` FOREIGN KEY (`route`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `routerequirements_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`start`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`end`) REFERENCES `maps` (`id`);
