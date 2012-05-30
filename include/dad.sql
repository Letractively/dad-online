-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-05-2012 a las 21:21:14
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
-- Estructura de tabla para la tabla `characters`
--

DROP TABLE IF EXISTS `characters`;
CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(8) NOT NULL,
  `user` int(11) NOT NULL,
  `race` int(11) NOT NULL,
  `map` int(11) NOT NULL,
  `hp` tinyint(3) unsigned NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `user` (`user`),
  KEY `race` (`race`),
  KEY `map` (`map`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Disparadores `characters`
--
DROP TRIGGER IF EXISTS `maxhpinsert`;
DELIMITER //
CREATE TRIGGER `maxhpinsert` BEFORE INSERT ON `characters`
 FOR EACH ROW begin if new.hp > 100 then set new.hp = 100; end if; end
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`item`),
  KEY `charid` (`charid`),
  KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charquestmobs`
--

DROP TABLE IF EXISTS `charquestmobs`;
CREATE TABLE IF NOT EXISTS `charquestmobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `questmob` int(11) NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`questmob`),
  KEY `charid` (`charid`),
  KEY `questmob` (`questmob`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charquests`
--

DROP TABLE IF EXISTS `charquests`;
CREATE TABLE IF NOT EXISTS `charquests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `quest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`quest`),
  KEY `charid` (`charid`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charspells`
--

DROP TABLE IF EXISTS `charspells`;
CREATE TABLE IF NOT EXISTS `charspells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `spell` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid_2` (`charid`,`spell`),
  KEY `charid` (`charid`),
  KEY `spell` (`spell`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `completequests`
--

DROP TABLE IF EXISTS `completequests`;
CREATE TABLE IF NOT EXISTS `completequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL,
  `quest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `charid` (`charid`,`quest`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapmobs`
--

DROP TABLE IF EXISTS `mapmobs`;
CREATE TABLE IF NOT EXISTS `mapmobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map` int(11) NOT NULL,
  `mob` int(11) NOT NULL,
  `rate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `map_2` (`map`,`mob`),
  KEY `map` (`map`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapnpcs`
--

DROP TABLE IF EXISTS `mapnpcs`;
CREATE TABLE IF NOT EXISTS `mapnpcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map` int(11) NOT NULL,
  `npc` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `map_2` (`map`,`npc`),
  KEY `map` (`map`),
  KEY `npc` (`npc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maps`
--

DROP TABLE IF EXISTS `maps`;
CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mobs`
--

DROP TABLE IF EXISTS `mobs`;
CREATE TABLE IF NOT EXISTS `mobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `npcquests`
--

DROP TABLE IF EXISTS `npcquests`;
CREATE TABLE IF NOT EXISTS `npcquests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `npc` int(11) NOT NULL,
  `quest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `npc_2` (`npc`,`quest`),
  KEY `npc` (`npc`),
  KEY `quest` (`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `npcs`
--

DROP TABLE IF EXISTS `npcs`;
CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questitems`
--

DROP TABLE IF EXISTS `questitems`;
CREATE TABLE IF NOT EXISTS `questitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `quest_2` (`quest`,`item`),
  KEY `quest` (`quest`),
  KEY `item` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questmobs`
--

DROP TABLE IF EXISTS `questmobs`;
CREATE TABLE IF NOT EXISTS `questmobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest` int(11) NOT NULL,
  `mob` int(11) NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `quest_2` (`quest`,`mob`),
  KEY `quest` (`quest`),
  KEY `mob` (`mob`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quests`
--

DROP TABLE IF EXISTS `quests`;
CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `races`
--

DROP TABLE IF EXISTS `races`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `start_2` (`start`,`end`),
  KEY `start` (`start`),
  KEY `end` (`end`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spells`
--

DROP TABLE IF EXISTS `spells`;
CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `accesslevel` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Restricciones para tablas volcadas
--

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
  ADD CONSTRAINT `completequests_ibfk_6` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `completequests_ibfk_1` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `completequests_ibfk_2` FOREIGN KEY (`charid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `completequests_ibfk_3` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `completequests_ibfk_4` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `completequests_ibfk_5` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Filtros para la tabla `mapmobs`
--
ALTER TABLE `mapmobs`
  ADD CONSTRAINT `mapmobs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapmobs_ibfk_2` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`),
  ADD CONSTRAINT `mapmobs_ibfk_3` FOREIGN KEY (`mob`) REFERENCES `mobs` (`id`);

--
-- Filtros para la tabla `mapnpcs`
--
ALTER TABLE `mapnpcs`
  ADD CONSTRAINT `mapnpcs_ibfk_1` FOREIGN KEY (`map`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `mapnpcs_ibfk_2` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `mapnpcs_ibfk_3` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`);

--
-- Filtros para la tabla `npcquests`
--
ALTER TABLE `npcquests`
  ADD CONSTRAINT `npcquests_ibfk_1` FOREIGN KEY (`npc`) REFERENCES `npcs` (`id`),
  ADD CONSTRAINT `npcquests_ibfk_2` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `npcquests_ibfk_3` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`);

--
-- Filtros para la tabla `questitems`
--
ALTER TABLE `questitems`
  ADD CONSTRAINT `questitems_ibfk_1` FOREIGN KEY (`quest`) REFERENCES `quests` (`id`),
  ADD CONSTRAINT `questitems_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `questitems_ibfk_3` FOREIGN KEY (`item`) REFERENCES `items` (`id`);

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
  ADD CONSTRAINT `races_ibfk_8` FOREIGN KEY (`class`) REFERENCES `classes` (`id`);

--
-- Filtros para la tabla `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`start`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`end`) REFERENCES `maps` (`id`),
  ADD CONSTRAINT `routes_ibfk_3` FOREIGN KEY (`end`) REFERENCES `maps` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
