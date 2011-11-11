-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2011 at 06:28 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id_project`, `url`, `caption`, `is_seo`, `is_context`, `active`) VALUES
(3, 'promo-venta.ru', '', '1', '0', '1'),
(4, 'venta-group.ru', '', '1', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `projects_access_role`
--

CREATE TABLE IF NOT EXISTS `projects_access_role` (
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_role` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `pay_percent` float DEFAULT '0',
  PRIMARY KEY (`id_project`,`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Чей это текущий проект, проект-роль-пользователь-процент';

--
-- Dumping data for table `projects_access_role`
--

INSERT INTO `projects_access_role` (`id_project`, `id_role`, `id_user`, `pay_percent`) VALUES
(3, 8, 11, 0),
(3, 6, 13, 1),
(3, 4, 12, 3),
(4, 4, 10, 1),
(4, 6, 13, 2),
(4, 8, 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo`
--

CREATE TABLE IF NOT EXISTS `projects_seo` (
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_sape` int(11) NOT NULL DEFAULT '0',
  `id_webmaster` int(11) NOT NULL DEFAULT '0',
  `date_create` int(11) NOT NULL DEFAULT '0',
  `date_payment` int(11) NOT NULL DEFAULT '0',
  `abonement` float NOT NULL DEFAULT '0',
  `consecutive_calculation` enum('1','0') NOT NULL DEFAULT '0',
  `liveinternet_password` varchar(255) DEFAULT '',
  `metrika` varchar(255) DEFAULT '',
  `sape_money` int(11) DEFAULT '0',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `max_seo_pay` float DEFAULT '0',
  PRIMARY KEY (`id_project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='seo параметры проекта';

--
-- Dumping data for table `projects_seo`
--

INSERT INTO `projects_seo` (`id_project`, `id_sape`, `id_webmaster`, `date_create`, `date_payment`, `abonement`, `consecutive_calculation`, `liveinternet_password`, `metrika`, `sape_money`, `active`, `max_seo_pay`) VALUES
(4, 0, 0, 0, 1320955200, 1, '0', '', '', 1, '1', 3361),
(3, 123523, 1111, 0, 1323979200, 25000, '0', '12304', '333', 3000, '1', 41920);

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_money`
--

CREATE TABLE IF NOT EXISTS `projects_seo_money` (
  `id_project` int(11) NOT NULL DEFAULT '0',
  `money` float NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_project`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='деньги проекта';

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_query`
--

CREATE TABLE IF NOT EXISTS `projects_seo_query` (
  `id_seo_query` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_seo_search_system` int(11) NOT NULL DEFAULT '0',
  `id_project_url` int(11) NOT NULL DEFAULT '0',
  `query` varchar(255) NOT NULL DEFAULT '',
  `last_url` varchar(255) NOT NULL DEFAULT '',
  `wordstat` int(11) NOT NULL DEFAULT '0',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_seo_query`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='seo запросы' AUTO_INCREMENT=117 ;

--
-- Dumping data for table `projects_seo_query`
--

INSERT INTO `projects_seo_query` (`id_seo_query`, `id_project`, `id_seo_search_system`, `id_project_url`, `query`, `last_url`, `wordstat`, `active`) VALUES
(84, 4, 2, 0, 'создание сайтов', '', 0, '1'),
(85, 4, 2, 0, 'создать сайт', '', 0, '1'),
(100, 3, 2, 0, 'тестовый запрос 1', '', 0, '1'),
(101, 3, 2, 0, 'тестовый запрос 2', '', 0, '1'),
(108, 3, -1, 0, 'гугл', '', 0, '1'),
(107, 3, 2, 0, 'москва', '', 0, '1'),
(109, 3, 2, 0, 'новый запрос', '', 0, '1'),
(111, 3, -4, 0, 'mail.ru', '', 0, '1'),
(115, 3, 4, 0, 'запрос из питера', '', 0, '1'),
(116, 3, 8, 0, 'первый Владимир', '', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_query_money`
--

CREATE TABLE IF NOT EXISTS `projects_seo_query_money` (
  `id_query` int(11) NOT NULL DEFAULT '0',
  `money` float NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_query`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='деньги по запросу';

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_search_system`
--

CREATE TABLE IF NOT EXISTS `projects_seo_search_system` (
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_seo_search_system` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_project`,`id_seo_search_system`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='seo проект - поисковая система, позиция для последовательног';

--
-- Dumping data for table `projects_seo_search_system`
--

INSERT INTO `projects_seo_search_system` (`id_project`, `id_seo_search_system`, `position`) VALUES
(4, 2, 2),
(3, -1, 200),
(3, 2, 98),
(3, 8, 97),
(3, -4, 300),
(3, 4, 99);

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_search_system_exs`
--

CREATE TABLE IF NOT EXISTS `projects_seo_search_system_exs` (
  `id_exs` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL DEFAULT '0',
  `id_seo_search_system` int(11) NOT NULL DEFAULT '0',
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  PRIMARY KEY (`id_exs`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='правила расчёта для проектов' AUTO_INCREMENT=72 ;

--
-- Dumping data for table `projects_seo_search_system_exs`
--

INSERT INTO `projects_seo_search_system_exs` (`id_exs`, `id_project`, `id_seo_search_system`, `from`, `to`) VALUES
(64, 3, -1, 1, 10),
(60, 3, 2, 20, 50),
(59, 3, 2, 1, 20),
(57, 4, 2, 1, 10),
(71, 3, 8, 1, 23),
(70, 3, 4, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_search_system_exs_price`
--

CREATE TABLE IF NOT EXISTS `projects_seo_search_system_exs_price` (
  `id_exs` int(11) NOT NULL DEFAULT '0',
  `id_seo_query` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id_exs`,`id_seo_query`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='правила расчёта для проектов';

--
-- Dumping data for table `projects_seo_search_system_exs_price`
--

INSERT INTO `projects_seo_search_system_exs_price` (`id_exs`, `id_seo_query`, `price`) VALUES
(59, 100, 100),
(60, 100, 50),
(59, 107, 23),
(57, 84, 100),
(60, 109, 50),
(60, 101, 20),
(59, 101, 30),
(57, 85, 12),
(59, 109, 100),
(60, 107, 12),
(64, 108, 100),
(71, 116, 11),
(70, 115, 200);

-- --------------------------------------------------------

--
-- Table structure for table `projects_seo_url`
--

CREATE TABLE IF NOT EXISTS `projects_seo_url` (
  `id_project_url` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_project_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='url проекта' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seo_search_system`
--

CREATE TABLE IF NOT EXISTS `seo_search_system` (
  `id_seo_search_system` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `lr` varchar(255) NOT NULL DEFAULT '',
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id_seo_search_system`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Поисковые системы' AUTO_INCREMENT=19 ;

--
-- Dumping data for table `seo_search_system`
--

INSERT INTO `seo_search_system` (`id_seo_search_system`, `parent`, `name`, `class`, `lr`, `active`, `position`) VALUES
(1, 0, 'Yandex.ru', 'Yandex', '', '1', -4),
(2, 1, 'Москва', 'Yandex', '213', '1', 2),
(3, 1, 'Самара', 'Yandex', '51', '1', 3),
(4, 1, 'Санкт-Петербург', 'Yandex', '10174', '1', 4),
(5, 1, 'Иваново', 'Yandex', '225', '1', 5),
(8, 1, 'Владимир', 'Yandex', '192', '1', 8),
(9, 1, 'Нижний Новгород', 'Yandex', '47', '1', 9),
(10, 1, 'Екатеринбург', 'Yandex', '54', '1', 10),
(11, 1, 'Новосибирск', 'Yandex', '65', '1', 11),
(12, 1, 'Краснодар', 'Yandex', '35', '1', 12),
(13, 1, 'Ростов-на-Дону', 'Yandex', '39', '1', 13),
(14, 1, 'Химки', 'Yandex', '10758', '1', 14),
(-1, 0, 'Google.ru', 'Google', '', '1', -2),
(-2, 0, 'Google.com', 'GoogleCom', '', '1', -1),
(-4, 0, 'Mail.ru', 'Mail', '', '1', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Основные страницы системы' AUTO_INCREMENT=32 ;

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
(30, 29, 'Сайты', '', '', '', 'sites', 'projects/projects.php', 29, '0', '1', '1', '0', ''),
(31, 24, 'Поисковые системы', '', '', '', 'searchsystems', 'settings/search_systems.php', 30, '0', '1', '1', '0', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Модуль и доступ роли' AUTO_INCREMENT=86 ;

--
-- Dumping data for table `site_modul_access`
--

INSERT INTO `site_modul_access` (`id`, `id_modul`, `id_role`) VALUES
(19, 23, 1),
(84, 15, 1),
(72, 17, 1),
(76, 16, 6),
(81, 1, 8),
(69, 31, 1),
(14, 18, 1),
(15, 19, 1),
(16, 20, 1),
(17, 21, 1),
(18, 22, 1),
(31, 26, 1),
(75, 16, 4),
(26, 24, 1),
(27, 25, 1),
(80, 1, 4),
(74, 16, 1),
(73, 1, 1),
(83, 1, 7),
(79, 16, 8),
(77, 16, 7),
(82, 1, 6),
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Пользователи сайта' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `role`, `login`, `password`, `email`, `active`, `email_message`, `system_message`) VALUES
(1, 'Shevlyakov Nikita', 1, 'shevlyakov.nikita', '698d51a19d8a121ce581499d7b701668', 'shevlyakov.nikita@gmail.com', '1', '1', '1'),
(10, 'Скобелев Роман', 4, 'skobelev', '96e79218965eb72c92a549dd5a330112', 'skobelev@venta-group.ru', '1', '1', '1'),
(11, 'Клиент', 8, 'client', '96e79218965eb72c92a549dd5a330112', 'client@yandex.ru', '1', '1', '1'),
(12, 'Курбатов Тимур', 4, 'kyrbatov.t', '96e79218965eb72c92a549dd5a330112', 'kyrbatov.t@venta-group.ru', '1', '1', '1'),
(13, 'Николаенко Рада', 6, 'nikolaenko.r', '7fa8282ad93047a4d6fe6111c93b308a', 'nikolaenko.r@venta-group.ru', '1', '1', '1'),
(14, 'Юдаков Дмитрий', 6, 'yudakov.d', '96e79218965eb72c92a549dd5a330112', 'yudakov.d@venta-group.ru', '1', '1', '1'),
(15, 'Клиент 2', 8, '677037', '96e79218965eb72c92a549dd5a330112', 'sadad@gmail.com', '1', '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
