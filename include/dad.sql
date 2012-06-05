-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-06-2012 a las 11:00:38
-- Versión del servidor: 5.5.22
-- Versión de PHP: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `dad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `battlenpcs`
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
-- Disparadores `battlenpcs`
--
DROP TRIGGER IF EXISTS `npcmaxhpinsert`;
DELIMITER //
CREATE TRIGGER `npcmaxhpinsert` BEFORE INSERT ON `battlenpcs`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `npcmaxhp`;
DELIMITER //
CREATE TRIGGER `npcmaxhp` BEFORE UPDATE ON `battlenpcs`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `battles`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Disparadores `battles`
--
DROP TRIGGER IF EXISTS `mobmaxhpinsert`;
DELIMITER //
CREATE TRIGGER `mobmaxhpinsert` BEFORE INSERT ON `battles`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `mobmaxhp`;
DELIMITER //
CREATE TRIGGER `mobmaxhp` BEFORE UPDATE ON `battles`
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
-- Estructura de tabla para la tabla `characters`
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
-- Disparadores `characters`
--
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
DROP TRIGGER IF EXISTS `maxhp`;
DELIMITER //
CREATE TRIGGER `maxhp` BEFORE UPDATE ON `characters`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charitems`
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
-- Estructura de tabla para la tabla `charquestmobs`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charquests`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `charquests`
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
-- Estructura de tabla para la tabla `charspells`
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
-- Estructura de tabla para la tabla `classes`
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
-- Estructura de tabla para la tabla `completequests`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `completequests`
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
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drops`
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
-- Disparadores `drops`
--
DROP TRIGGER IF EXISTS `maxrateinsert`;
DELIMITER //
CREATE TRIGGER `maxrateinsert` BEFORE INSERT ON `drops`
 FOR EACH ROW begin if new.rate > 100 then set new.rate = 100; end if; end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `maxrate`;
DELIMITER //
CREATE TRIGGER `maxrate` BEFORE UPDATE ON `drops`
 FOR EACH ROW begin if new.rate > 100 then set new.rate = 100; end if; end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
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
-- Estructura de tabla para la tabla `mapmobs`
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
-- Estructura de tabla para la tabla `mapnpcs`
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
-- Estructura de tabla para la tabla `maps`
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
-- Estructura de tabla para la tabla `mobs`
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
-- Disparadores `mobs`
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
-- Estructura de tabla para la tabla `mobspells`
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
-- Estructura de tabla para la tabla `mobtypes`
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
-- Estructura de tabla para la tabla `npcquests`
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
-- Estructura de tabla para la tabla `npcs`
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
-- Disparadores `npcs`
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
-- Estructura de tabla para la tabla `npcspells`
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
-- Estructura de tabla para la tabla `questitems`
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
-- Estructura de tabla para la tabla `questmobs`
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
-- Estructura de tabla para la tabla `quests`
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
-- Estructura de tabla para la tabla `races`
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
-- Estructura de tabla para la tabla `rewards`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routerequirements`
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
-- Estructura de tabla para la tabla `routes`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spells`
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
-- Estructura de tabla para la tabla `users`
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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `battlenpcs`
--
ALTER TABLE `battlenpcs`
  ADD CONSTRAINT `battlenpcs_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `battlenpcs_ibfk_2` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`);

--
-- Filtros para la tabla `battles`
--
ALTER TABLE `battles`
  ADD CONSTRAINT `battles_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `battles_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Filtros para la tabla `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`race`) REFERENCES `races` (`id`),
  ADD CONSTRAINT `characters_ibfk_3` FOREIGN KEY (`map`) REFERENCES `maps` (`id`);

--
-- Filtros para la tabla `charitems`
--
ALTER TABLE `charitems`
  ADD CONSTRAINT `charitems_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charitems_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Filtros para la tabla `charquestmobs`
--
ALTER TABLE `charquestmobs`
  ADD CONSTRAINT `charquestmobs_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charquestmobs_ibfk_2` FOREIGN KEY (`questmob`) REFERENCES `questmobs` (`id`);

--
-- Filtros para la tabla `charquests`
--
ALTER TABLE `charquests`
  ADD CONSTRAINT `charquests_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Filtros para la tabla `charspells`
--
ALTER TABLE `charspells`
  ADD CONSTRAINT `charspells_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `charspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Filtros para la tabla `completequests`
--
ALTER TABLE `completequests`
  ADD CONSTRAINT `completequests_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `completequests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Filtros para la tabla `drops`
--
ALTER TABLE `drops`
  ADD CONSTRAINT `drops_ibfk_1` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`),
  ADD CONSTRAINT `drops_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Filtros para la tabla `mapmobs`
--
ALTER TABLE `mapmobs`
  ADD CONSTRAINT `mapmobs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapmobs_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Filtros para la tabla `mapnpcs`
--
ALTER TABLE `mapnpcs`
  ADD CONSTRAINT `mapnpcs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapnpcs_ibfk_2` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`);

--
-- Filtros para la tabla `mobs`
--
ALTER TABLE `mobs`
  ADD CONSTRAINT `mobs_ibfk_1` FOREIGN KEY (`type`) REFERENCES `mobtypes` (`id`);

--
-- Filtros para la tabla `mobspells`
--
ALTER TABLE `mobspells`
  ADD CONSTRAINT `mobspells_ibfk_1` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`),
  ADD CONSTRAINT `mobspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Filtros para la tabla `mobtypes`
--
ALTER TABLE `mobtypes`
  ADD CONSTRAINT `mobtypes_ibfk_1` FOREIGN KEY (`startspell`) REFERENCES `spells` (`id`);

--
-- Filtros para la tabla `npcquests`
--
ALTER TABLE `npcquests`
  ADD CONSTRAINT `npcquests_ibfk_1` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `npcquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Filtros para la tabla `npcs`
--
ALTER TABLE `npcs`
  ADD CONSTRAINT `npcs_ibfk_1` FOREIGN KEY (`race`) REFERENCES `races` (`id`);

--
-- Filtros para la tabla `npcspells`
--
ALTER TABLE `npcspells`
  ADD CONSTRAINT `npcspells_ibfk_1` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `npcspells_ibfk_2` FOREIGN KEY (`spell`) REFERENCES `spells` (`id`);

--
-- Filtros para la tabla `questitems`
--
ALTER TABLE `questitems`
  ADD CONSTRAINT `questitems_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `questitems_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Filtros para la tabla `questmobs`
--
ALTER TABLE `questmobs`
  ADD CONSTRAINT `questmobs_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `questmobs_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Filtros para la tabla `races`
--
ALTER TABLE `races`
  ADD CONSTRAINT `races_ibfk_1` FOREIGN KEY (`startmap`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `races_ibfk_2` FOREIGN KEY (`startspell`) REFERENCES `spells` (`id`),
  ADD CONSTRAINT `races_ibfk_3` FOREIGN KEY (`class`) REFERENCES `classes` (`id`);

--
-- Filtros para la tabla `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `rewards_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

--
-- Filtros para la tabla `routerequirements`
--
ALTER TABLE `routerequirements`
  ADD CONSTRAINT `routerequirements_ibfk_1` FOREIGN KEY (`route`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `routerequirements_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Filtros para la tabla `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`start`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`end`) REFERENCES `maps` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
