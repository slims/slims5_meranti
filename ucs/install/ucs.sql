-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2010 at 10:43 AM
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
  `promoted` smallint(1) DEFAULT '0',
  `labels` text COLLATE utf8_unicode_ci,
  `frequency_id` int(11) NOT NULL DEFAULT '0',
  `spec_detail_info` text COLLATE utf8_unicode_ci,
  `input_date` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`biblio_id`),
  KEY `references_idx` (`gmd_id`,`publisher_id`,`language_id`,`publish_place_id`),
  KEY `classification` (`classification`),
  KEY `biblio_flag_idx` (`opac_hide`,`promoted`),
  FULLTEXT KEY `title_ft_idx` (`title`,`series_title`),
  FULLTEXT KEY `notes_ft_idx` (`notes`),
  FULLTEXT KEY `labels` (`labels`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `biblio`
--

INSERT INTO `biblio` (`biblio_id`, `gmd_id`, `title`, `edition`, `isbn_issn`, `publisher_id`, `publish_year`, `collation`, `series_title`, `call_number`, `language_id`, `source`, `publish_place_id`, `classification`, `notes`, `image`, `file_att`, `opac_hide`, `promoted`, `labels`, `frequency_id`, `spec_detail_info`, `input_date`, `last_update`) VALUES
(1, 1, 'PHP 5 for dummies', NULL, '0764541668', 1, 2004, 'xiv, 392 p. : ill. ; 24 cm.', 'For dummies', '005.13/3-22 Jan p', 'en', NULL, 1, '005.13/3 22', NULL, 'php5_dummies.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 15:36:50', '2007-11-29 16:26:59'),
(2, 1, 'Linux In a Nutshell', 'Fifth Edition', '9780596009304', 2, 2005, 'xiv, 925 p. : ill. ; 23 cm.', 'In a Nutshell', '005.4/32-22 Ell l', 'en', NULL, 2, '005.4/32 22', '', 'linux_in_a_nutshell.jpg', NULL, 0, 0, NULL, 0, '', '2007-11-29 15:53:35', '2009-12-31 04:19:25'),
(3, 1, 'The Definitive Guide to MySQL 5', NULL, '9781590595350', 3, 2005, '784p.', 'Definitive Guide Series', '005.75/85-22 Kof d', 'en', NULL, NULL, '005.75/85 22', NULL, 'mysql_def_guide.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:01:08', '2007-11-29 16:26:33'),
(4, 1, 'Cathedral and the Bazaar: Musings on Linux and Open Source by an Accidental Revolutionary', NULL, '0-596-00108-8', 2, 2001, '208p.', NULL, '005.4/3222 Ray c', 'en', NULL, 2, '005.4/32 22', 'The Cathedral & the Bazaar is a must for anyone who cares about the future of the computer industry or the dynamics of the information economy. This revised and expanded paperback edition includes new material on open source developments in 1999 and 2000. Raymond''s clear and effective writing style accurately describing the benefits of open source software has been key to its success. (Source: http://safari.oreilly.com/0596001088)', 'cathedral_bazaar.jpg', 'cathedral-bazaar.pdf', 0, 0, NULL, 0, NULL, '2007-11-29 16:14:44', '2007-11-29 16:25:43'),
(5, 1, 'Producing open source software : how to run a successful free software project', '1st ed.', '9780596007591', 2, 2005, 'xx, 279 p. ; 24 cm.', NULL, '005.1-22 Fog p', 'en', NULL, 2, '005.1 22', 'Includes index.', 'producing_oss.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:20:45', '2007-11-29 16:31:21'),
(6, 1, 'PostgreSQL : a comprehensive guide to building, programming, and administering PostgreSQL databases', '1st ed.', '0735712573', 4, 2003, 'xvii, 790 p. : ill. ; 23cm.', 'DeveloperÃ¢â‚¬â„¢s library', '005.75/85-22 Kor p', 'en', NULL, 3, '005.75/85 22', 'PostgreSQL is the world''s most advanced open-source database. PostgreSQL is the most comprehensive, in-depth, and easy-to-read guide to this award-winning database. This book starts with a thorough overview of SQL, a description of all PostgreSQL data types, and a complete explanation of PostgreSQL commands.', 'postgresql.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:29:33', '0000-00-00 00:00:00'),
(7, 1, 'Web application architecture : principles, protocols, and practices', NULL, '0471486566', 5, 2003, 'xi, 357 p. : ill. ; 23 cm.', NULL, '005.7/2-21 Leo w', 'en', NULL, 1, '005.7/2 21', 'An in-depth examination of the core concepts and general principles of Web application development.\r\nThis book uses examples from specific technologies (e.g., servlet API or XSL), without promoting or endorsing particular platforms or APIs. Such knowledge is critical when designing and debugging complex systems. This conceptual understanding makes it easier to learn new APIs that arise in the rapidly changing Internet environment.', 'webapp_arch.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:41:57', '2007-11-29 16:32:46'),
(8, 1, 'Ajax : creating Web pages with asynchronous JavaScript and XML', NULL, '9780132272674', 6, 2007, 'xxii, 384 p. : ill. ; 24 cm.', 'Bruce PerensÃ¢â‚¬â„¢ Open Source series', '006.7/86-22 Woy a', 'en', NULL, 4, '006.7/86 22', 'Using Ajax, you can build Web applications with the sophistication and usability of traditional desktop applications and you can do it using standards and open source software. Now, for the first time, there''s an easy, example-driven guide to Ajax for every Web and open source developer, regardless of experience.', 'ajax.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:47:20', '0000-00-00 00:00:00'),
(9, 1, 'The organization of information', '2nd ed.', '1563089769', 7, 2004, 'xxvii, 417 p. : ill. ; 27 cm.', 'Library and information science text series', '025-22 Tay o', 'en', NULL, 5, '025 22', 'A basic textbook for students of library and information studies, and a guide for practicing school library media specialists. Describes the impact of global forces and the school district on the development and operation of a media center, the technical and human side of management, programmatic activities, supportive services to students, and the quality and quantity of resources available to support programs.', 'organization_information.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:54:12', '2007-11-29 16:27:20'),
(10, 1, 'Library and Information Center Management', '7th ed.', '9781591584063', 7, 2007, 'xxviii, 492 p. : ill. ; 27 cm.', 'Library and information science text series', '025.1-22 Stu l', 'en', NULL, 5, '025.1 22', NULL, 'library_info_center.JPG', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 16:58:51', '2007-11-29 16:27:40'),
(11, 1, 'Information Architecture for the World Wide Web: Designing Large-Scale Web Sites', '2nd ed.', '9780596000356', 2, 2002, '500p.', NULL, '006.7-22 Mor i', 'en', NULL, 6, '006.7 22', 'Information Architecture for the World Wide Web is about applying the principles of architecture and library science to web site design. Each website is like a public building, available for tourists and regulars alike to breeze through at their leisure. The job of the architect is to set up the framework for the site to make it comfortable and inviting for people to visit, relax in, and perhaps even return to someday.', 'information_arch.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 17:26:14', '2007-11-29 16:32:25'),
(12, 1, 'Corruption and development', NULL, '9780714649023', 8, 1998, '166 p. : ill. ; 22 cm.', NULL, '364.1 Rob c', 'en', NULL, 7, '364.1/322/091724 21', 'The articles assembled in this volume offer a fresh approach to analysing the problem of corruption in developing countries and the k means to tackle the phenomenon.', 'corruption_development.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 17:45:30', '2007-11-29 16:20:53'),
(13, 1, 'Corruption and development : the anti-corruption campaigns', NULL, '0230525504', 9, 2007, '310p.', NULL, '364.1 Bra c', 'en', NULL, 8, '364.1/323091724 22', 'This book provides a multidisciplinary interrogation of the global anti-corruption campaigns of the last ten years, arguing that while some positive change is observable, the period is also replete with perverse consequences and unintended outcomes', 'corruption_development_anti_campaign.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 17:49:49', '2007-11-29 16:19:48'),
(14, 1, 'Pigs at the trough : how corporate greed and political corruption are undermining America', NULL, '1400047714', 10, 2003, '275 p. ; 22 cm.', NULL, '364.1323 Huf p', 'en', NULL, 8, '364.1323', NULL, 'pigs_at_trough.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 17:56:00', '2007-11-29 16:18:33'),
(15, 1, 'Lords of poverty : the power, prestige, and corruption of the international aid business', NULL, '9780871134691', 11, 1994, 'xvi, 234 p. ; 22 cm.', NULL, '338.9 Han l', 'en', NULL, 8, '338.9/1/091724 20', 'Lords of Poverty is a case study in betrayals of a public trust. The shortcomings of aid are numerous, and serious enough to raise questions about the viability of the practice at its most fundamental levels. Hancocks report is thorough, deeply shocking, and certain to cause critical reevaluation of the governments motives in giving foreign aid, and of the true needs of our intended beneficiaries.', 'lords_of_poverty.jpg', NULL, 0, 0, NULL, 0, NULL, '2007-11-29 18:08:13', '2007-11-29 16:13:11');

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

INSERT INTO `biblio_author` (`biblio_id`, `author_id`, `level`) VALUES
(1, 1, 1),
(2, 2, 1),
(2, 3, 2),
(2, 4, 2),
(2, 5, 2),
(2, 6, 2),
(3, 7, 1),
(3, 8, 2),
(4, 9, 1),
(5, 10, 1),
(6, 11, 1),
(6, 12, 2),
(7, 13, 1),
(7, 14, 2),
(8, 15, 1),
(9, 16, 1),
(10, 17, 1),
(10, 18, 2),
(11, 19, 1),
(11, 20, 2),
(12, 21, 1),
(13, 22, 1),
(14, 23, 1),
(15, 24, 1);

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

INSERT INTO `biblio_topic` (`biblio_id`, `topic_id`, `level`) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 3, 1),
(2, 4, 2),
(2, 5, 2),
(3, 1, 1),
(3, 6, 2),
(3, 7, 2),
(4, 4, 1),
(4, 8, 2),
(5, 8, 1),
(5, 9, 2),
(6, 1, 1),
(6, 7, 2),
(7, 2, 1),
(7, 10, 2),
(8, 1, 1),
(8, 2, 2),
(9, 11, 1),
(9, 12, 2),
(9, 13, 2),
(10, 11, 1),
(10, 14, 2),
(12, 15, 1),
(12, 16, 2),
(13, 15, 1),
(14, 15, 1),
(15, 15, 1),
(15, 17, 2);

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
(3, 'Welcome To Admin Page', '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="5">\r\n<tbody>\r\n<tr>\r\n<td width="5%" valign="top"><a class="icon biblioIcon" href="?mod=bibliography"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Bibliography</div>\r\nThe Bibliography module lets you manage your library bibliographical data. It also include collection items management     to manage a copies of your library collection so it can be used in library circulation.</td>\r\n<td width="5%" valign="top"><a class="icon circulationIcon" href="?mod=circulation"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Circulation</div>\r\nThe Circulation module is used for doing library circulation transaction such as collection loans and return. In this module you can also create loan rules that will be used in loan transaction proccess.</td>\r\n</tr>\r\n<tr>\r\n<td width="5%" valign="top"><a class="icon memberIcon" href="?mod=membership"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Membership</div>\r\nThe Membership module lets you manage library members such adding, updating and also removing. You can also manage membership type in this module.<br /><br /></td>\r\n<td width="5%" valign="top"><a class="icon stockTakeIcon" href="?mod=stock_take"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Stock Take</div>\r\nThe Stock Take module is the easy way to do Stock Opname for your library collections. Follow several steps that ease your pain in Stock Opname proccess. <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td width="5%" valign="top"><a class="icon masterFileIcon" href="?mod=master_file"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Master File</div>\r\nThe Master File modules lets you manage referential data that will be used by another modules. It include Authority File management such     as Authority, Subject/Topic List, GMD and other data.</td>\r\n<td width="5%" valign="top"><a class="icon systemIcon" href="?mod=system"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">System</div>\r\nThe System module is used to configure application globally.</td>\r\n</tr>\r\n<tr>\r\n<td width="5%" valign="top"><a class="icon reportIcon" href="?mod=reporting"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Reporting</div>\r\n<p>Reporting lets you view various type of reports regardings membership data, circulation data and bibliographic data. All compiled on-the-fly from         current library database.</p>\r\n<br /></td>\r\n<td width="5%" valign="top"><a class="icon serialIcon" href="?mod=serial_control"></a></td>\r\n<td width="45%" valign="top">\r\n<div class="heading">Serial Control</div>\r\nSerial Control module help you manage library''s serial publication subscription. You can track issues for each subscription.\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'adminhome', '2009-09-13 19:48:16', '2009-09-13 22:02:11'),
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
(1, 4, 1, 1),
(1, 5, 1, 1),
(1, 6, 1, 1),
(1, 7, 1, 1),
(1, 8, 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `mst_author`
--

INSERT INTO `mst_author` (`author_id`, `author_name`, `authority_type`, `auth_list`, `input_date`, `last_update`) VALUES
(1, 'Valade, Janet', 'p', NULL, '2007-11-29', '2007-11-29'),
(2, 'Siever, Ellen', 'p', NULL, '2007-11-29', '2007-11-29'),
(3, 'Love, Robert', 'p', NULL, '2007-11-29', '2007-11-29'),
(4, 'Robbins, Arnold', 'p', NULL, '2007-11-29', '2007-11-29'),
(5, 'Figgins, Stephen', 'p', NULL, '2007-11-29', '2007-11-29'),
(6, 'Weber, Aaron', 'p', NULL, '2007-11-29', '2007-11-29'),
(7, 'Kofler, Michael', 'p', NULL, '2007-11-29', '2007-11-29'),
(8, 'Kramer, David', 'p', NULL, '2007-11-29', '2007-11-29'),
(9, 'Raymond, Eric', 'p', NULL, '2007-11-29', '2007-11-29'),
(10, 'Fogel, Karl', 'p', NULL, '2007-11-29', '2007-11-29'),
(11, 'Douglas, Korry', 'p', NULL, '2007-11-29', '2007-11-29'),
(12, 'Douglas, Susan', 'p', NULL, '2007-11-29', '2007-11-29'),
(13, 'Shklar, Leon', 'p', NULL, '2007-11-29', '2007-11-29'),
(14, 'Rosen, Richard', 'p', NULL, '2007-11-29', '2007-11-29'),
(15, 'Woychowsky, Edmond', 'p', NULL, '2007-11-29', '2007-11-29'),
(16, 'Taylor, Arlene G.', 'p', NULL, '2007-11-29', '2007-11-29'),
(17, 'Stueart, Robert D.', 'p', NULL, '2007-11-29', '2007-11-29'),
(18, 'Moran, Barbara B.', 'p', NULL, '2007-11-29', '2007-11-29'),
(19, 'Morville, Peter', 'p', NULL, '2007-11-29', '2007-11-29'),
(20, 'Rosenfeld, Louis', 'p', NULL, '2007-11-29', '2007-11-29'),
(21, 'Robinson, Mark', 'p', NULL, '2007-11-29', '2007-11-29'),
(22, 'Bracking, Sarah', 'p', NULL, '2007-11-29', '2007-11-29'),
(23, 'Huffington, Arianna Stassinopoulos', 'p', NULL, '2007-11-29', '2007-11-29'),
(24, 'Hancock, Graham', 'p', NULL, '2007-11-29', '2007-11-29'),
(25, 'Sulistyo Basuki', 'p', NULL, '2009-10-24', '2009-10-24'),
(26, 'Google Inc.', 'o', NULL, '2009-10-26', '2009-10-26'),
(27, 'Herman, Eric', 'p', NULL, '2009-10-26', '2009-10-26'),
(28, 'Keir Thomas', 'p', NULL, '2009-10-26', '2009-10-26'),
(29, 'Hirata, Andrea.', 'p', NULL, '2009-10-26', '2009-10-26'),
(30, 'Doyle, Arthur Conan,', 'p', NULL, '2009-10-27', '2009-10-27'),
(31, 'Gibson, John Michael.', 'p', NULL, '2009-10-27', '2009-10-27'),
(32, 'Green, Richard Lancelyn.', 'p', NULL, '2009-10-27', '2009-10-27'),
(33, 'George Adhitjondro', 'p', NULL, '2010-01-07', '2010-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `mst_coll_type`
--

CREATE TABLE IF NOT EXISTS `mst_coll_type` (
  `coll_type_id` int(3) NOT NULL AUTO_INCREMENT,
  `coll_type_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `input_date` date DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  PRIMARY KEY (`coll_type_id`),
  UNIQUE KEY `coll_type_name` (`coll_type_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mst_coll_type`
--

INSERT INTO `mst_coll_type` (`coll_type_id`, `coll_type_name`, `input_date`, `last_update`) VALUES
(1, 'Reference', '2007-11-29', '2007-11-29'),
(2, 'Textbook', '2007-11-29', '2007-11-29'),
(3, 'Fiction', '2007-11-29', '2007-11-29');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

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
('id', 'Indonesia', '2009-09-13', '2009-09-13'),
('en', 'English', '2009-09-13', '2009-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `mst_location`
--

CREATE TABLE IF NOT EXISTS `mst_location` (
  `location_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `location_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location_name` (`location_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mst_location`
--

INSERT INTO `mst_location` (`location_id`, `location_name`, `input_date`, `last_update`) VALUES
('SL', 'My Library', '2009-09-13', '2009-09-13');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mst_place`
--

INSERT INTO `mst_place` (`place_id`, `place_name`, `input_date`, `last_update`) VALUES
(1, 'Hoboken, NJ', '2007-11-29', '2007-11-29'),
(2, 'Sebastopol, CA', '2007-11-29', '2007-11-29'),
(3, 'Indianapolis', '2007-11-29', '2007-11-29'),
(4, 'Upper Saddle River, NJ', '2007-11-29', '2007-11-29'),
(5, 'Westport, Conn.', '2007-11-29', '2007-11-29'),
(6, 'Cambridge, Mass', '2007-11-29', '2007-11-29'),
(7, 'London', '2007-11-29', '2007-11-29'),
(8, 'New York', '2007-11-29', '2007-11-29'),
(9, 'Ujungberung, Bandung :', '2009-10-26', '2009-10-26'),
(10, 'New York :', '2009-10-27', '2009-10-27');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `mst_publisher`
--

INSERT INTO `mst_publisher` (`publisher_id`, `publisher_name`, `input_date`, `last_update`) VALUES
(1, 'Wiley', '2007-11-29', '2007-11-29'),
(2, 'OReilly', '2007-11-29', '2007-11-29'),
(3, 'Apress', '2007-11-29', '2007-11-29'),
(4, 'Sams', '2007-11-29', '2007-11-29'),
(5, 'John Wiley', '2007-11-29', '2007-11-29'),
(6, 'Prentice Hall', '2007-11-29', '2007-11-29'),
(7, 'Libraries Unlimited', '2007-11-29', '2007-11-29'),
(8, 'Taylor & Francis Inc.', '2007-11-29', '2007-11-29'),
(9, 'Palgrave Macmillan', '2007-11-29', '2007-11-29'),
(10, 'Crown publishers', '2007-11-29', '2007-11-29'),
(11, 'Atlantic Monthly Press', '2007-11-29', '2007-11-29'),
(12, 'Didistribusikan oleh Mizan Media Utama,', '2009-10-26', '2009-10-26'),
(13, 'Avenel Books,', '2009-10-27', '2009-10-27');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `mst_topic`
--

INSERT INTO `mst_topic` (`topic_id`, `topic`, `topic_type`, `auth_list`, `input_date`, `last_update`) VALUES
(1, 'Programming', 't', NULL, '2007-11-29', '2007-11-29'),
(2, 'Website', 't', NULL, '2007-11-29', '2007-11-29'),
(3, 'Operating System', 't', NULL, '2007-11-29', '2007-11-29'),
(4, 'Linux', 't', NULL, '2007-11-29', '2007-11-29'),
(5, 'Computer', 't', NULL, '2007-11-29', '2007-11-29'),
(6, 'Database', 't', NULL, '2007-11-29', '2007-11-29'),
(7, 'RDBMS', 't', NULL, '2007-11-29', '2007-11-29'),
(8, 'Open Source', 't', NULL, '2007-11-29', '2007-11-29'),
(9, 'Project', 't', NULL, '2007-11-29', '2007-11-29'),
(10, 'Design', 't', NULL, '2007-11-29', '2007-11-29'),
(11, 'Information', 't', NULL, '2007-11-29', '2007-11-29'),
(12, 'Organization', 't', NULL, '2007-11-29', '2007-11-29'),
(13, 'Metadata', 't', NULL, '2007-11-29', '2007-11-29'),
(14, 'Library', 't', NULL, '2007-11-29', '2007-11-29'),
(15, 'Corruption', 't', NULL, '2007-11-29', '2007-11-29'),
(16, 'Development', 't', NULL, '2007-11-29', '2007-11-29'),
(17, 'Poverty', 't', NULL, '2007-11-29', '2007-11-29');

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
(1, 'library_name', 's:7:"Senayan";'),
(2, 'library_subname', 's:37:"Open Source Library Management System";'),
(3, 'template', 'a:2:{s:5:"theme";s:7:"default";s:3:"css";s:26:"template/default/style.css";}'),
(4, 'admin_template', 'a:2:{s:5:"theme";s:4:"igos";s:3:"css";s:29:"admin_template/igos/style.css";}'),
(5, 'default_lang', 's:5:"en_US";'),
(6, 'opac_result_num', 's:2:"10";'),
(7, 'enable_promote_titles', 'N;'),
(8, 'quick_return', 'b:1;'),
(9, 'allow_loan_date_change', 'b:0;'),
(10, 'loan_limit_override', 'b:0;'),
(11, 'enable_xml_detail', 'b:1;'),
(12, 'enable_xml_result', 'b:1;'),
(13, 'allow_file_download', 'b:1;'),
(14, 'session_timeout', 's:4:"7200";'),
(15, 'circulation_receipt', 'b:1;'),
(16, 'barcode_encoding', 's:4:"128B";');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`log_id`, `log_type`, `id`, `log_location`, `log_msg`, `log_date`) VALUES
(1, 'staff', '1', 'bibliography', 'Administrator DELETE bibliographic data (Membongkar Gurita Cikeas) with biblio_id (16)', '2010-02-07 16:57:17'),
(2, 'staff', '1', 'system', 'Administrator Log Out from application from address ::1', '2010-02-07 17:16:02'),
(3, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-07 23:27:34'),
(4, 'member', 'M00002', 'circulation', 'Administrator start transaction with member (M00002)', '2010-02-08 00:16:08'),
(5, 'member', 'M00002', 'circulation', 'Administrator finish circulation transaction with member (M00002)', '2010-02-08 00:16:32'),
(6, 'member', 'M00002', 'circulation', 'Administrator start transaction with member (M00002)', '2010-02-08 00:16:56'),
(7, 'member', 'M00002', 'circulation', 'Administrator return item B00003 for member (M00002)', '2010-02-08 00:17:03'),
(8, 'member', 'M00002', 'circulation', 'Administrator return item B00002 for member (M00002)', '2010-02-08 00:17:06'),
(9, 'member', 'M00002', 'circulation', 'Administrator extend loan for item B00001 for member (M00002)', '2010-02-08 00:17:08'),
(10, 'member', 'M00002', 'circulation', 'Administrator finish circulation transaction with member (M00002)', '2010-02-08 00:17:21'),
(11, 'staff', '1', 'system', 'Administrator Log Out from application from address ::1', '2010-02-08 01:06:50'),
(12, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-09 17:15:06'),
(13, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-09 18:20:44'),
(14, 'staff', '1', 'system', 'Administrator Log Out from application from address ::1', '2010-02-09 18:42:36'),
(15, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-10 05:47:32'),
(16, 'staff', 'admin', 'Login', 'Login success for user admin from address 152.118.148.226', '2010-02-10 06:20:37'),
(17, 'staff', '1', 'system', 'Administrator Log Out from application from address 152.118.148.226', '2010-02-10 06:21:18'),
(18, 'staff', 'admin', 'Login', 'Login success for user admin from address 152.118.41.171', '2010-02-10 06:47:02'),
(19, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-10 14:40:22'),
(20, 'staff', '1', 'system', 'Administrator Log Out from application from address ::1', '2010-02-10 16:57:40'),
(21, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-11 14:27:34'),
(22, 'staff', 'admin', 'Login', 'Login success for user admin from address 127.0.0.1', '2010-02-11 14:31:52'),
(23, 'staff', '1', 'system', 'Administrator Log Out from application from address 127.0.0.1', '2010-02-11 14:33:59'),
(24, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-11 22:27:07'),
(25, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-13 01:28:42'),
(26, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-13 07:49:45'),
(27, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-15 16:27:59'),
(28, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-16 06:00:09'),
(29, 'staff', '1', 'bibliography', 'Administrator insert item data (Z00001) with title (Web application architecture : principles, protocols, and practices)', '2010-02-16 06:00:52'),
(30, 'staff', '1', 'bibliography', 'Administrator insert item data (Z00002) with title (Web application architecture : principles, protocols, and practices)', '2010-02-16 06:01:12'),
(31, 'staff', '1', 'system', 'Administrator Log Out from application from address ::1', '2010-02-16 06:01:52'),
(32, 'staff', 'admin', 'Login', 'Login success for user admin from address 127.0.0.1', '2010-02-17 05:30:21'),
(33, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-17 05:30:33'),
(34, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-19 10:57:30'),
(35, 'staff', '1', 'bibliography', 'Administrator insert item data (B00012) with title (Linux In a Nutshell)', '2010-02-19 11:03:15'),
(36, 'member', 'M00002', 'circulation', 'Administrator return item (B00001) with title (Ajax : creating Web pages with asynchronous JavaScript and XML) with Quick Return method', '2010-02-19 11:04:26'),
(37, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-26 08:17:05'),
(38, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-26 10:09:18'),
(39, 'staff', 'admin', 'Login', 'Login success for user admin from address 127.0.0.1', '2010-02-27 15:49:39'),
(40, 'staff', 'admin', 'Login', 'Login success for user admin from address 127.0.0.1', '2010-02-27 16:39:22'),
(41, 'staff', 'admin', 'Login', 'Login success for user admin from address 127.0.0.1', '2010-02-27 17:14:50'),
(42, 'staff', '1', 'bibliography', 'Administrator insert item data (B00001) with title (Linux In a Nutshell)', '2010-02-27 20:32:04'),
(43, 'staff', '1', 'bibliography', 'Administrator insert item data (B00002) with title (Web application architecture : principles, protocols, and practices)', '2010-02-27 20:32:19'),
(44, 'staff', '1', 'bibliography', 'Administrator insert item data (B00003) with title (Information Architecture for the World Wide Web: Designing Large-Scale Web Sites)', '2010-02-27 20:32:33'),
(45, 'staff', '1', 'bibliography', 'Administrator insert item data (B00004) with title (Producing open source software : how to run a successful free software project)', '2010-02-27 20:32:45'),
(46, 'staff', '1', 'bibliography', 'Administrator insert item data (B00005) with title (Library and Information Center Management)', '2010-02-27 20:32:58'),
(47, 'staff', '', 'system', 'Log Out from application from address 127.0.0.1', '2010-02-27 21:55:32'),
(48, 'staff', 'admin', 'Login', 'Login success for user admin from address 127.0.0.1', '2010-02-27 22:02:08'),
(49, 'staff', '1', 'bibliography', 'Importing 5 item records from file : senayan_item_export.csv', '2010-02-27 22:04:41'),
(50, 'member', 'M00001', 'circulation', 'Administrator start transaction with member (M00001)', '2010-02-27 22:46:42'),
(51, 'member', 'M00001', 'circulation', 'Administrator finish circulation transaction with member (M00001)', '2010-02-27 22:46:54'),
(52, 'member', 'M00001', 'circulation', 'Administrator start transaction with member (M00001)', '2010-02-27 22:47:16'),
(53, 'member', 'M00001', 'circulation', 'Administrator finish circulation transaction with member (M00001)', '2010-02-27 22:47:19'),
(54, 'member', 'M00002', 'circulation', 'Administrator start transaction with member (M00002)', '2010-02-27 22:47:28'),
(55, 'member', 'M00002', 'circulation', 'Administrator finish circulation transaction with member (M00002)', '2010-02-27 22:47:30'),
(56, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-27 17:28:40'),
(57, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:28:50'),
(58, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:30:34'),
(59, 'staff', '1', 'bibliography', 'Administrator insert item data (B00001) with title (Linux In a Nutshell)', '2010-02-27 17:30:59'),
(60, 'staff', '1', 'bibliography', 'Administrator insert item data (B00002) with title (Web application architecture : principles, protocols, and practices)', '2010-02-27 17:31:12'),
(61, 'staff', '1', 'bibliography', 'Administrator insert item data (B00003) with title (Information Architecture for the World Wide Web: Designing Large-Scale Web Sites)', '2010-02-27 17:31:25'),
(62, 'staff', '1', 'bibliography', 'Administrator insert item data (B00004) with title (Producing open source software : how to run a successful free software project)', '2010-02-27 17:31:36'),
(63, 'staff', '1', 'bibliography', 'Administrator insert item data (B00005) with title (Library and Information Center Management)', '2010-02-27 17:31:48'),
(64, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:34:10'),
(65, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:34:45'),
(66, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:35:36'),
(67, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:36:03'),
(68, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:36:52'),
(69, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:40:05'),
(70, 'staff', '1', 'system', 'Administrator change application global configuration', '2010-02-27 17:57:24'),
(71, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-28 00:15:47'),
(72, 'staff', 'admin', 'Login', 'Login success for user admin from address ::1', '2010-02-28 01:54:46');

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
(1, 'admin', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', '2010-02-28 01:54:46', '::1', 'a:1:{i:0;s:1:"1";}', '2009-09-13', '2009-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_count`
--

CREATE TABLE IF NOT EXISTS `visitor_count` (
  `visitor_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `institution` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `checkin_date` datetime NOT NULL,
  PRIMARY KEY (`visitor_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visitor_count`
--

