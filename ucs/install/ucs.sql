-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 09, 2010 at 08:21 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ucs`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_log`
--

CREATE TABLE IF NOT EXISTS `backup_log` (
  `backup_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `backup_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `backup_file` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`backup_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `backup_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio`
--

CREATE TABLE IF NOT EXISTS `biblio` (
  `biblio_id` int(11) NOT NULL AUTO_INCREMENT,
  `orig_biblio_id` INT(11) NOT NULL,
  `gmd_id` int(3) DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `edition` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isbn_issn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `publish_year` int(4) DEFAULT NULL,
  `collation` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `series_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `call_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_id` char(5) COLLATE utf8_unicode_ci DEFAULT 'en',
  `source` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish_place_id` int(11) DEFAULT NULL,
  `classification` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_att` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opac_hide` smallint(1) DEFAULT '0',
  `promoted` smallint(1) DEFAULT '1',
  `labels` text COLLATE utf8_unicode_ci,
  `frequency_id` int(11) NOT NULL DEFAULT '0',
  `spec_detail_info` text COLLATE utf8_unicode_ci,
  `node_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_date` datetime NOT NULL,
  `input_date` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`biblio_id`),
  UNIQUE KEY `orig_biblio_idx` (`orig_biblio_id`, `node_id`),
  KEY `references_idx` (`gmd_id`,`publisher_id`,`language_id`,`publish_place_id`),
  KEY `classification` (`classification`),
  KEY `node_id` (`node_id`),
  FULLTEXT KEY `title_ft_idx` (`title`,`series_title`),
  FULLTEXT KEY `notes_ft_idx` (`notes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `biblio`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio_author`
--

CREATE TABLE IF NOT EXISTS `biblio_author` (
  `biblio_id` int(11) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `level` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`biblio_id`,`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biblio_author`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio_topic`
--

CREATE TABLE IF NOT EXISTS `biblio_topic` (
  `biblio_id` int(11) NOT NULL DEFAULT '0',
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `level` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`biblio_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biblio_topic`
--


-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `content_path` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`content_id`),
  KEY `content_path` (`content_path`),
  FULLTEXT KEY `content_title` (`content_title`),
  FULLTEXT KEY `content_desc` (`content_desc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_title`, `content_desc`, `content_path`, `input_date`, `last_update`) VALUES
(1, 'Library Information', '<h3>Contact Information</h3>\r\n<p><strong>Address :</strong> <br /> Jenderal Sudirman Road, Senayan, Jakarta, Indonesia - Postal Code : 10270 <br /> <strong>Phone Number :</strong> <br /> (021) 5711144 <br /> <strong>Fax Number :</strong> <br /> (021) 5711144</p>\r\n<h3>Opening Hours</h3>\r\n<p><strong>Monday - Friday :</strong> <br /> Open : 08.00 AM<br /> Break : 12.00 - 13.00 PM<br /> Close : 20.00 PM <br /> <strong>Saturday  :</strong> <br /> Open : 08.00 AM<br /> Break : 12.00 - 13.00 PM<br /> Close : 17.00 PM</p>\r\n<h3>Collections</h3>\r\n<p>We have many types of collections in our library, range from Fictions to Sciences Material, from printed material to digital collections such CD-ROM, CD, VCD and DVD. We also collect daily serials publications such as newspaper and also monthly serials such as magazines.</p>\r\n<h3>Library Membership</h3>\r\n<p>To be able to loan our library collections, you must first become library member. There is terms and conditions that you must obey.</p>', 'libinfo', '2009-09-13 19:48:16', '2009-09-13 19:48:16'),
(2, 'Help On Usage', '<h3>Searching</h3>\r\n<p>There is 2 method available on searching library catalog. The first one is <strong>SIMPLE SEARCH</strong>, which is the simplest method on searching catalog, you just enter any keyword, either it contained in document titles, authors name or subjects. You can supply more than one keywords in Simple Search method and it will expanding your search results.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>ADVANCED SEARCH</strong>, lets you define keywords in more specific fields. If you want your keywords only contained in title field, then type your keyword in Title field and the system will scope it search only on <strong>Title</strong> field, not in other fields. Location field lets you narrowing search results by specific location, so only collection that exists in selected location get fetched by system.</p>', 'help', '2009-09-13 19:48:16', '2009-09-13 19:48:16'),
(3, 'Welcome To Admin Page', '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="5">\r\n<tbody>\r\n<tr>\r\n<td width="5%" valign="top"><a class="icon nodesIcon" href="?mod=bibliography"></a></td>\r\n<td width="95%" valign="top">\r\n<div class="heading">Union Catalog Server</div>\r\nThe Union Catalog Server (UCS) is catalog polling server for SENAYAN Library Management System (SLiMS). Node of SLiMS or other library application which can send HTTP POST with JSON format encoding, send their catalog data to this UCS. To see the JSON format encoding used, please read developer reference.</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'adminhome', '2009-09-13 19:48:16', '2010-03-06 15:38:09'),
(4, 'Homepage Info', '<p>Welcome To <strong>Senayan Library''s</strong> Online Public Access Catalog (OPAC). Use OPAC to search collection in our library.</p>', 'headerinfo', '2009-09-13 19:48:16', '2009-09-13 19:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `group_access`
--

CREATE TABLE IF NOT EXISTS `group_access` (
  `group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `r` int(1) NOT NULL DEFAULT '0',
  `w` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`,`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `group_access`
--

INSERT INTO `group_access` (`group_id`, `module_id`, `r`, `w`) VALUES
(1, 1, 1, 1),
(1, 2, 1, 1),
(1, 3, 1, 1),
(1, 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_author`
--

CREATE TABLE IF NOT EXISTS `mst_author` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `authority_type` enum('p','o','c') COLLATE utf8_unicode_ci DEFAULT 'p',
  `auth_list` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_date` date NOT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`author_id`),
  UNIQUE KEY `author_name` (`author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_author`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_frequency`
--

CREATE TABLE IF NOT EXISTS `mst_frequency` (
  `frequency_id` int(11) NOT NULL AUTO_INCREMENT,
  `frequency` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `language_prefix` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_increment` smallint(6) DEFAULT NULL,
  `time_unit` enum('day','week','month','year') COLLATE utf8_unicode_ci DEFAULT 'day',
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY (`frequency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mst_frequency`
--

INSERT INTO `mst_frequency` (`frequency_id`, `frequency`, `language_prefix`, `time_increment`, `time_unit`, `input_date`, `last_update`) VALUES
(1, 'Weekly', 'en', 1, 'week', '2009-05-23', '2009-05-23'),
(2, 'Bi-weekly', 'en', 2, 'week', '2009-05-23', '2009-05-23'),
(3, 'Fourth-Nightly', 'en', 14, 'day', '2009-05-23', '2009-05-23'),
(4, 'Monthly', 'en', 1, 'month', '2009-05-23', '2009-05-23'),
(5, 'Bi-Monthly', 'en', 2, 'month', '2009-05-23', '2009-05-23'),
(6, 'Quarterly', 'en', 3, 'month', '2009-05-23', '2009-05-23'),
(7, '3 Times a Year', 'en', 4, 'month', '2009-05-23', '2009-05-23'),
(8, 'Annualy', 'en', 1, 'year', '2009-05-23', '2009-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `mst_gmd`
--

CREATE TABLE IF NOT EXISTS `mst_gmd` (
  `gmd_id` int(11) NOT NULL AUTO_INCREMENT,
  `gmd_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gmd_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `icon_image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_date` date NOT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`gmd_id`),
  UNIQUE KEY `gmd_name` (`gmd_name`),
  UNIQUE KEY `gmd_code` (`gmd_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `mst_gmd`
--

INSERT INTO `mst_gmd` (`gmd_id`, `gmd_code`, `gmd_name`, `icon_image`, `input_date`, `last_update`) VALUES
(1, 'TE', 'Text', NULL, '2009-09-13', '2009-09-13'),
(2, 'AR', 'Art Original', NULL, '2009-09-13', '2009-09-13'),
(3, 'CH', 'Chart', NULL, '2009-09-13', '2009-09-13'),
(4, 'CO', 'Computer Software', NULL, '2009-09-13', '2009-09-13'),
(5, 'DI', 'Diorama', NULL, '2009-09-13', '2009-09-13'),
(6, 'FI', 'Filmstrip', NULL, '2009-09-13', '2009-09-13'),
(7, 'FL', 'Flash Card', NULL, '2009-09-13', '2009-09-13'),
(8, 'GA', 'Game', NULL, '2009-09-13', '2009-09-13'),
(9, 'GL', 'Globe', NULL, '2009-09-13', '2009-09-13'),
(10, 'KI', 'Kit', NULL, '2009-09-13', '2009-09-13'),
(11, 'MA', 'Map', NULL, '2009-09-13', '2009-09-13'),
(12, 'MI', 'Microform', NULL, '2009-09-13', '2009-09-13'),
(13, 'MN', 'Manuscript', NULL, '2009-09-13', '2009-09-13'),
(14, 'MO', 'Model', NULL, '2009-09-13', '2009-09-13'),
(15, 'MP', 'Motion Picture', NULL, '2009-09-13', '2009-09-13'),
(16, 'MS', 'Microscope Slide', NULL, '2009-09-13', '2009-09-13'),
(17, 'MU', 'Music', NULL, '2009-09-13', '2009-09-13'),
(18, 'PI', 'Picture', NULL, '2009-09-13', '2009-09-13'),
(19, 'RE', 'Realia', NULL, '2009-09-13', '2009-09-13'),
(20, 'SL', 'Slide', NULL, '2009-09-13', '2009-09-13'),
(21, 'SO', 'Sound Recording', NULL, '2009-09-13', '2009-09-13'),
(22, 'TD', 'Technical Drawing', NULL, '2009-09-13', '2009-09-13'),
(23, 'TR', 'Transparency', NULL, '2009-09-13', '2009-09-13'),
(24, 'VI', 'Video Recording', NULL, '2009-09-13', '2009-09-13'),
(25, 'EQ', 'Equipment', NULL, '2009-09-13', '2009-09-13'),
(26, 'CF', 'Computer File', NULL, '2009-09-13', '2009-09-13'),
(27, 'CA', 'Cartographic Material', NULL, '2009-09-13', '2009-09-13'),
(28, 'CD', 'CD-ROM', NULL, '2009-09-13', '2009-09-13'),
(29, 'MV', 'Multimedia', NULL, '2009-09-13', '2009-09-13'),
(30, 'ER', 'Electronic Resource', NULL, '2009-09-13', '2009-09-13'),
(31, 'DVD', 'Digital Versatile Disc', NULL, '2009-09-13', '2009-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `mst_label`
--

CREATE TABLE IF NOT EXISTS `mst_label` (
  `label_id` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `label_desc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label_image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY (`label_id`),
  UNIQUE KEY `label_name` (`label_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mst_label`
--

INSERT INTO `mst_label` (`label_id`, `label_name`, `label_desc`, `label_image`, `input_date`, `last_update`) VALUES
(1, 'label-new', 'New Title', 'label-new.png', '2009-09-13', '2009-09-13'),
(2, 'label-favorite', 'Favorite Title', 'label-favorite.png', '2009-09-13', '2009-09-13'),
(3, 'label-multimedia', 'Multimedia', 'label-multimedia.png', '2009-09-13', '2009-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `mst_language`
--

CREATE TABLE IF NOT EXISTS `mst_language` (
  `language_id` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `language_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` date DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`language_id`),
  UNIQUE KEY `language_name` (`language_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mst_language`
--

INSERT INTO `mst_language` (`language_id`, `language_name`, `input_date`, `last_update`) VALUES
('en', 'English', '2010-03-07', '2010-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `mst_module`
--

CREATE TABLE IF NOT EXISTS `mst_module` (
  `module_id` int(3) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `module_path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `module_name` (`module_name`,`module_path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mst_module`
--

INSERT INTO `mst_module` (`module_id`, `module_name`, `module_path`, `module_desc`) VALUES
(1, 'bibliography', 'bibliography', 'Manage your bibliographic/catalog and items/copies database'),
(2, 'master_file', 'master_file', 'Manage your referential data that will be used by other modules'),
(3, 'system', 'system', 'Configure system behaviour, user and backups'),
(4, 'reporting', 'reporting', 'Real time and dynamic report about library collections and circulation');

-- --------------------------------------------------------

--
-- Table structure for table `mst_place`
--

CREATE TABLE IF NOT EXISTS `mst_place` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `place_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` date DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`place_id`),
  UNIQUE KEY `place_name` (`place_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_place`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_publisher`
--

CREATE TABLE IF NOT EXISTS `mst_publisher` (
  `publisher_id` int(11) NOT NULL AUTO_INCREMENT,
  `publisher_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` date DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`publisher_id`),
  UNIQUE KEY `publisher_name` (`publisher_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_publisher`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_topic`
--

CREATE TABLE IF NOT EXISTS `mst_topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_type` enum('t','g','n','tm','gr','oc') COLLATE utf8_unicode_ci NOT NULL,
  `auth_list` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_date` date DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `topic` (`topic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_topic`
--


-- --------------------------------------------------------

--
-- Table structure for table `nodes_poll`
--

CREATE TABLE IF NOT EXISTS `nodes_poll` (
  `poll_id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `node_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `node_poll_time` datetime NOT NULL,
  `node_poll_end` datetime DEFAULT NULL,
  `is_online` smallint(1) DEFAULT '0',
  PRIMARY KEY (`poll_id`),
  KEY `is_online` (`is_online`),
  KEY `node_id` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `nodes_poll`
--


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `setting_id` int(3) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'library_name', 's:20:"Union Catalog Server";'),
(2, 'library_subname', 's:31:"SLiMS Union Catalog Application";'),
(3, 'themes', 's:7:"default";'),
(4, 'default_lang', 's:5:"en_US";'),
(5, 'opac_result_num', 's:2:"20";'),
(6, 'enable_xml_detail', 'b:0;'),
(7, 'enable_xml_result', 'b:1;'),
(8, 'session_timeout', 's:4:"7200";');

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE IF NOT EXISTS `system_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` enum('staff','member','system') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'staff',
  `id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log_msg` text COLLATE utf8_unicode_ci NOT NULL,
  `log_date` datetime NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_type` (`log_type`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `system_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `realname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groups` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_date` date DEFAULT '0000-00-00',
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `realname` (`realname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `realname`, `passwd`, `last_login`, `last_login_ip`, `groups`, `input_date`, `last_update`) VALUES
(1, 'admin', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', '2010-03-09 06:31:19', '::1', 'a:1:{i:0;s:1:"1";}', '2009-09-13', '2009-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` date DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`group_id`, `group_name`, `input_date`, `last_update`) VALUES
(1, 'Administrator', '2010-03-01', '2010-03-01');
