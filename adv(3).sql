-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2011 at 04:56 PM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adv`
--

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `caption` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Настройки системы' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `param`, `value`, `active`, `caption`) VALUES
(1, 'sape_login', 'remul2', '1', 'Логин в сейп'),
(2, 'sape_password', '56#23ss', '1', 'Пароль в сейп'),
(3, 'webmaster_login', 'venta-adv', '1', 'Логин в webmaster'),
(4, 'webmaster_password', '56#23s', '1', 'Пароль в webmaster'),
(5, 'metrika_login', 'metrika', '1', 'Логин Metrika'),
(6, 'metrika_password', '111', '1', 'Пароль Metrika');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `caption` varchar(255) NOT NULL DEFAULT '',
  `is_seo` enum('1','0') NOT NULL DEFAULT '0',
  `is_context` enum('1','0') NOT NULL DEFAULT '0',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_access`
--

CREATE TABLE IF NOT EXISTS `projects_access` (
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_role` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_project`,`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Чей это текущий проект, проект-роль-пользователь';

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo`
--

CREATE TABLE IF NOT EXISTS `projects_seo` (
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_sape` int(11) NOT NULL DEFAULT '0',
  `id_webmaster` int(11) NOT NULL DEFAULT '0',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site_modul`
--

CREATE TABLE IF NOT EXISTS `site_modul` (
  `id_modul` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `caption` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `file` varchar(255) NOT NULL DEFAULT '',
  `position` int(11) NOT NULL DEFAULT '0',
  `index` enum('0','1') NOT NULL DEFAULT '0',
  `inmenu` enum('1','0') NOT NULL DEFAULT '1',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `delete` enum('1','0') NOT NULL DEFAULT '0',
  `css_class` varchar(255) DEFAULT '',
  PRIMARY KEY (`id_modul`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Основные страницы системы' AUTO_INCREMENT=31 ;

--
-- Dumping data for table `site_modul`
--

INSERT INTO `site_modul` (`id_modul`, `parent`, `caption`, `keywords`, `description`, `text`, `url`, `file`, `position`, `index`, `inmenu`, `active`, `delete`, `css_class`) VALUES
(1, 0, 'Личный кабинет', '', '', '<p>Добрый день</p>\r\n<p>Вы находитесь в Venta-Adv, Выберите нужный раздел</p>', 'main', 'settings/test.php', 1, '1', '1', '1', '0', ''),
(19, 18, 'Роли пользователей', '', '', '', 'roles', 'settings/user_role.php', 23, '0', '1', '1', '0', ''),
(23, 18, 'Пользователи системы', '', '', '', 'list', 'settings/users.php', 19, '0', '1', '1', '0', ''),
(18, 17, 'Пользователи', '', '', '', 'users', 'user_role.php', 18, '0', '1', '1', '0', ''),
(15, 0, 'Настройки системы', '', '', '', 'settings', 'text.php', 28, '0', '1', '1', '0', ''),
(16, 15, 'Личные', '', '', '', 'user', 'settings/user.php', 16, '0', '1', '1', '0', ''),
(17, 15, 'Основные', '', '', '<p>тут Вы можете расставить доступы для пользователей системы</p>\r\n<p>&nbsp;</p>', 'system', 'settings/main.php', 17, '0', '1', '1', '0', ''),
(24, 17, 'Другие настройки', '', '', '', 'other', 'main.php', 24, '0', '1', '1', '0', ''),
(25, 24, 'API систем', '', '', '', 'passwords', 'settings/system_password.php', 25, '0', '1', '1', '0', ''),
(29, 0, 'Проекты', '', '', '', 'projects', 'text.php', 26, '0', '1', '1', '0', 'projects'),
(30, 29, 'Сайты', '', '', '', 'sites', 'projects/projects.php', 29, '0', '1', '1', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `site_modul_access`
--

CREATE TABLE IF NOT EXISTS `site_modul_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_modul` int(11) NOT NULL DEFAULT '0',
  `id_role` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_modul` (`id_modul`,`id_role`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Модуль и доступ роли' AUTO_INCREMENT=67 ;

--
-- Dumping data for table `site_modul_access`
--

INSERT INTO `site_modul_access` (`id`, `id_modul`, `id_role`) VALUES
(19, 23, 1),
(3, 2, 1),
(11, 17, 1),
(10, 16, 1),
(9, 15, 1),
(8, 14, 1),
(12, 0, 1),
(13, 12, 1),
(14, 18, 1),
(15, 19, 1),
(16, 20, 1),
(17, 21, 1),
(18, 22, 1),
(31, 26, 1),
(45, 1, 4),
(22, 16, 4),
(23, 11, 1),
(38, 1, 1),
(26, 24, 1),
(27, 25, 1),
(28, 15, 4),
(41, 16, 6),
(42, 16, 7),
(53, 1, 7),
(40, 1, 6),
(43, 15, 6),
(44, 15, 7),
(66, 1, 8),
(64, 30, 1),
(63, 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_modul_role`
--

CREATE TABLE IF NOT EXISTS `site_modul_role` (
  `id_modul_role` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL DEFAULT '',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_modul_role`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Роли пользователей' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `site_modul_role`
--

INSERT INTO `site_modul_role` (`id_modul_role`, `role`, `active`, `position`) VALUES
(1, 'Администратор', '0', 1),
(6, 'Аккаунт', '1', 3),
(7, 'SEO аналитик', '1', 4),
(4, 'Оптимизатор', '0', 2),
(8, 'Клиент', '1', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `role` int(11) NOT NULL DEFAULT '2',
  `login` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `email_message` enum('1','0') NOT NULL DEFAULT '1',
  `system_message` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Пользователи сайта' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `role`, `login`, `password`, `email`, `active`, `email_message`, `system_message`) VALUES
(1, 'Shevlyakov Nikita', 1, 'shevlyakov.nikita', '698d51a19d8a121ce581499d7b701668', 'shevlyakov.nikita@gmail.com', '1', '1', '1'),
(10, 'Скобелев Роман', 4, 'skobelev', '96e79218965eb72c92a549dd5a330112', 'skobelev@venta-group.ru', '1', '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
