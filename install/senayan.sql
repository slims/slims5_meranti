-- SENAYAN Library Automation
-- Version 3.0 stable 10
-- Core database structure


-- --------------------------------------------------------

--
-- Table structure for table `backup_log`
--

CREATE TABLE IF NOT EXISTS `backup_log` (
  `backup_log_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `backup_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `backup_file` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`backup_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `backup_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio`
--

CREATE TABLE IF NOT EXISTS `biblio` (
  `biblio_id` int(11) NOT NULL auto_increment,
  `gmd_id` int(3) default NULL,
  `title` text collate utf8_unicode_ci NOT NULL,
  `edition` varchar(50) collate utf8_unicode_ci default NULL,
  `isbn_issn` varchar(20) collate utf8_unicode_ci default NULL,
  `publisher_id` int(11) default NULL,
  `publish_year` int(4) default NULL,
  `collation` varchar(50) collate utf8_unicode_ci default NULL,
  `series_title` varchar(200) collate utf8_unicode_ci default NULL,
  `call_number` varchar(50) collate utf8_unicode_ci default NULL,
  `language_id` char(5) collate utf8_unicode_ci default 'en',
  `source` varchar(3) collate utf8_unicode_ci default NULL,
  `publish_place_id` int(11) default NULL,
  `classification` varchar(40) collate utf8_unicode_ci default NULL,
  `notes` text collate utf8_unicode_ci,
  `image` varchar(100) collate utf8_unicode_ci default NULL,
  `file_att` varchar(255) collate utf8_unicode_ci default NULL,
  `opac_hide` smallint(1) default '0',
  `promoted` smallint(1) default '0',
  `labels` text collate utf8_unicode_ci NULL,
  `frequency_id` int(11) NOT NULL default '0',
  `spec_detail_info` text collate utf8_unicode_ci,
  `input_date` datetime default NULL,
  `last_update` datetime default NULL,
  PRIMARY KEY  (`biblio_id`),
  KEY `references_idx` (`gmd_id`,`publisher_id`,`language_id`,`publish_place_id`),
  KEY `classification` (`classification`),
  KEY `biblio_flag_idx` (`opac_hide`,`promoted`),
  FULLTEXT KEY `title_ft_idx` (`title`,`series_title`),
  FULLTEXT KEY `notes_ft_idx` (`notes`),
  FULLTEXT KEY `labels` (`labels`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `biblio`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio_attachment`
--

CREATE TABLE IF NOT EXISTS `biblio_attachment` (
  `biblio_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `access_type` enum('public','private') collate utf8_unicode_ci NOT NULL,
  `access_limit` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  KEY `biblio_id` (`biblio_id`),
  KEY `file_id` (`file_id`),
  KEY `biblio_id_2` (`biblio_id`,`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biblio_attachment`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio_author`
--

CREATE TABLE IF NOT EXISTS `biblio_author` (
  `biblio_id` int(11) NOT NULL default '0',
  `author_id` int(11) NOT NULL default '0',
  `level` int(1) NOT NULL default '1',
  PRIMARY KEY  (`biblio_id`,`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biblio_author`
--


-- --------------------------------------------------------

--
-- Table structure for table `biblio_topic`
--

CREATE TABLE IF NOT EXISTS `biblio_topic` (
  `biblio_id` int(11) NOT NULL default '0',
  `topic_id` int(11) NOT NULL default '0',
  `level` int(1) NOT NULL default '1',
  PRIMARY KEY  (`biblio_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biblio_topic`
--


-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `content_id` int(11) NOT NULL auto_increment,
  `content_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `content_desc` text collate utf8_unicode_ci NOT NULL,
  `content_path` varchar(20) collate utf8_unicode_ci NOT NULL,
  `input_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY  (`content_id`),
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
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(11) NOT NULL auto_increment,
  `file_title` text collate utf8_unicode_ci NOT NULL,
  `file_name` text collate utf8_unicode_ci NOT NULL,
  `file_url` text collate utf8_unicode_ci,
  `file_dir` text collate utf8_unicode_ci,
  `mime_type` varchar(100) collate utf8_unicode_ci default NULL,
  `file_desc` text collate utf8_unicode_ci,
  `uploader_id` int(11) NOT NULL,
  `input_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY  (`file_id`),
  FULLTEXT KEY `file_name` (`file_name`),
  FULLTEXT KEY `file_dir` (`file_dir`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE IF NOT EXISTS `fines` (
  `fines_id` int(11) NOT NULL auto_increment,
  `fines_date` date NOT NULL,
  `member_id` varchar(20) collate utf8_unicode_ci NOT NULL,
  `debet` int(11) default '0',
  `credit` int(11) default '0',
  `description` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`fines_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `fines`
--


-- --------------------------------------------------------

--
-- Table structure for table `group_access`
--

CREATE TABLE IF NOT EXISTS `group_access` (
  `group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `r` int(1) NOT NULL default '0',
  `w` int(1) NOT NULL default '0',
  PRIMARY KEY  (`group_id`,`module_id`)
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
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
  `holiday_id` int(11) NOT NULL auto_increment,
  `holiday_dayname` varchar(20) collate utf8_unicode_ci NOT NULL,
  `holiday_date` date default NULL,
  `description` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`holiday_id`),
  UNIQUE KEY `holiday_dayname` (`holiday_dayname`,`holiday_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `holiday_dayname`, `holiday_date`, `description`) VALUES
(1, 'Mon', '2009-06-01', 'Tes Libur'),
(2, 'Tue', '2009-06-02', 'Tes Libur'),
(3, 'Wed', '2009-06-03', 'Tes Libur'),
(4, 'Thu', '2009-06-04', 'Tes Libur'),
(5, 'Fri', '2009-06-05', 'Tes Libur'),
(6, 'Sat', '2009-06-06', 'Tes Libur');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL auto_increment,
  `biblio_id` int(11) default NULL,
  `call_number` varchar(50) collate utf8_unicode_ci default NULL,
  `coll_type_id` int(3) default NULL,
  `item_code` varchar(20) collate utf8_unicode_ci default NULL,
  `inventory_code` varchar(200) collate utf8_unicode_ci default NULL,
  `received_date` date default NULL,
  `supplier_id` varchar(6) collate utf8_unicode_ci default NULL,
  `order_no` varchar(20) collate utf8_unicode_ci default NULL,
  `location_id` varchar(3) collate utf8_unicode_ci default NULL,
  `order_date` date default NULL,
  `item_status_id` char(3) collate utf8_unicode_ci default NULL,
  `site` varchar(50) collate utf8_unicode_ci default NULL,
  `source` int(1) NOT NULL default '0',
  `invoice` varchar(20) collate utf8_unicode_ci default NULL,
  `price` int(11) default NULL,
  `price_currency` varchar(10) collate utf8_unicode_ci default NULL,
  `invoice_date` date default NULL,
  `input_date` datetime NOT NULL,
  `last_update` datetime default NULL,
  PRIMARY KEY  (`item_id`),
  UNIQUE KEY `item_code` (`item_code`),
  KEY `item_references_idx` (`coll_type_id`,`location_id`,`item_status_id`),
  KEY `biblio_id_idx` (`biblio_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `item`
--


-- --------------------------------------------------------

--
-- Table structure for table `kardex`
--

CREATE TABLE IF NOT EXISTS `kardex` (
  `kardex_id` int(11) NOT NULL auto_increment,
  `date_expected` date NOT NULL,
  `date_received` date default NULL,
  `seq_number` varchar(25) collate utf8_unicode_ci default NULL,
  `notes` text collate utf8_unicode_ci,
  `serial_id` int(11) default NULL,
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY  (`kardex_id`),
  KEY `fk_serial` (`serial_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kardex`
--


-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `loan_id` int(11) NOT NULL auto_increment,
  `item_code` varchar(20) collate utf8_unicode_ci default NULL,
  `member_id` varchar(20) collate utf8_unicode_ci default NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `renewed` int(11) NOT NULL default '0',
  `loan_rules_id` int(11) NOT NULL default '0',
  `actual` date default NULL,
  `is_lent` int(11) NOT NULL default '0',
  `is_return` int(11) NOT NULL default '0',
  `return_date` date default NULL,
  PRIMARY KEY  (`loan_id`),
  KEY `item_code` (`item_code`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `loan`
--


-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `member_id` varchar(20) collate utf8_unicode_ci NOT NULL,
  `member_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `gender` int(1) NOT NULL,
  `birth_date` date default NULL,
  `member_type_id` int(6) default NULL,
  `member_address` varchar(255) collate utf8_unicode_ci default NULL,
  `member_email` varchar(100) collate utf8_unicode_ci default NULL,
  `postal_code` varchar(20) collate utf8_unicode_ci default NULL,
  `inst_name` varchar(100) collate utf8_unicode_ci default NULL,
  `is_new` int(1) default NULL,
  `member_image` varchar(200) collate utf8_unicode_ci default NULL,
  `pin` varchar(50) collate utf8_unicode_ci default NULL,
  `member_phone` varchar(50) collate utf8_unicode_ci default NULL,
  `member_fax` varchar(50) collate utf8_unicode_ci default NULL,
  `member_since_date` date default NULL,
  `register_date` date default NULL,
  `expire_date` date NOT NULL,
  `member_notes` text collate utf8_unicode_ci,
  `is_pending` smallint(1) NOT NULL default '0',
  `mpasswd` CHAR(32) NULL,
  `last_login` DATETIME NULL,
  `last_login_ip` VARCHAR(20) NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`member_id`),
  KEY `member_name` (`member_name`),
  KEY `member_type_id` (`member_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_name`, `gender`, `birth_date`, `member_type_id`, `member_address`, `member_email`, `postal_code`, `inst_name`, `is_new`, `member_image`, `pin`, `member_phone`, `member_fax`, `member_since_date`, `register_date`, `expire_date`, `member_notes`, `is_pending`, `input_date`, `last_update`) VALUES
('M00001', 'Hendro Wicaksono', 1, '1974-06-05', 1, '', 'hendrowicaksono@yahoo.com', '', 'Perpustakaan Depdiknas', NULL, NULL, '', '', '', '2009-04-15', '2009-04-15', '2010-04-15', '', 0, '2009-04-15', '2009-06-11'),
('M00002', 'Arie Nugraha', 1, '1982-12-06', 1, '', 'dicarve@yahoo.com', '', 'Perpustakaan Depdiknas', NULL, NULL, '', '', '', '2009-04-15', '2009-04-15', '2010-04-15', '', 0, '2009-04-15', '2009-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `mst_author`
--

CREATE TABLE IF NOT EXISTS `mst_author` (
  `author_id` int(11) NOT NULL auto_increment,
  `author_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `authority_type` enum('p','o','c') collate utf8_unicode_ci default 'p',
  `auth_list` varchar(20) collate utf8_unicode_ci default NULL,
  `input_date` date NOT NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`author_id`),
  UNIQUE KEY `author_name` (`author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_author`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_coll_type`
--

CREATE TABLE IF NOT EXISTS `mst_coll_type` (
  `coll_type_id` int(3) NOT NULL auto_increment,
  `coll_type_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`coll_type_id`),
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
  `frequency_id` int(11) NOT NULL auto_increment,
  `frequency` varchar(25) collate utf8_unicode_ci NOT NULL,
  `language_prefix` varchar(5) collate utf8_unicode_ci default NULL,
  `time_increment` smallint(6) default NULL,
  `time_unit` enum('day','week','month','year') collate utf8_unicode_ci default 'day',
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY  (`frequency_id`)
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
  `gmd_id` int(11) NOT NULL auto_increment,
  `gmd_code` varchar(3) collate utf8_unicode_ci default NULL,
  `gmd_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `icon_image` varchar(100) collate utf8_unicode_ci default NULL,
  `input_date` date NOT NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`gmd_id`),
  UNIQUE KEY `gmd_name` (`gmd_name`),
  UNIQUE KEY `gmd_code` (`gmd_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `mst_gmd`
--

INSERT INTO `mst_gmd` (`gmd_id`, `gmd_code`, `gmd_name`, `icon_image`, `input_date`, `last_update`) VALUES
(1, 'TE', 'Text', NULL, DATE(NOW()), DATE(NOW())),
(2, 'AR', 'Art Original', NULL, DATE(NOW()), DATE(NOW())),
(3, 'CH', 'Chart', NULL, DATE(NOW()), DATE(NOW())),
(4, 'CO', 'Computer Software', NULL, DATE(NOW()), DATE(NOW())),
(5, 'DI', 'Diorama', NULL, DATE(NOW()), DATE(NOW())),
(6, 'FI', 'Filmstrip', NULL, DATE(NOW()), DATE(NOW())),
(7, 'FL', 'Flash Card', NULL, DATE(NOW()), DATE(NOW())),
(8, 'GA', 'Game', NULL, DATE(NOW()), DATE(NOW())),
(9, 'GL', 'Globe', NULL, DATE(NOW()), DATE(NOW())),
(10, 'KI', 'Kit', NULL, DATE(NOW()), DATE(NOW())),
(11, 'MA', 'Map', NULL, DATE(NOW()), DATE(NOW())),
(12, 'MI', 'Microform', NULL, DATE(NOW()), DATE(NOW())),
(13, 'MN', 'Manuscript', NULL, DATE(NOW()), DATE(NOW())),
(14, 'MO', 'Model', NULL, DATE(NOW()), DATE(NOW())),
(15, 'MP', 'Motion Picture', NULL, DATE(NOW()), DATE(NOW())),
(16, 'MS', 'Microscope Slide', NULL, DATE(NOW()), DATE(NOW())),
(17, 'MU', 'Music', NULL, DATE(NOW()), DATE(NOW())),
(18, 'PI', 'Picture', NULL, DATE(NOW()), DATE(NOW())),
(19, 'RE', 'Realia', NULL, DATE(NOW()), DATE(NOW())),
(20, 'SL', 'Slide', NULL, DATE(NOW()), DATE(NOW())),
(21, 'SO', 'Sound Recording', NULL, DATE(NOW()), DATE(NOW())),
(22, 'TD', 'Technical Drawing', NULL, DATE(NOW()), DATE(NOW())),
(23, 'TR', 'Transparency', NULL, DATE(NOW()), DATE(NOW())),
(24, 'VI', 'Video Recording', NULL, DATE(NOW()), DATE(NOW())),
(25, 'EQ', 'Equipment', NULL, DATE(NOW()), DATE(NOW())),
(26, 'CF', 'Computer File', NULL, DATE(NOW()), DATE(NOW())),
(27, 'CA', 'Cartographic Material', NULL, DATE(NOW()), DATE(NOW())),
(28, 'CD', 'CD-ROM', NULL, DATE(NOW()), DATE(NOW())),
(29, 'MV', 'Multimedia', NULL, DATE(NOW()), DATE(NOW())),
(30, 'ER', 'Electronic Resource', NULL, DATE(NOW()), DATE(NOW())),
(31, 'DVD', 'Digital Versatile Disc', NULL, DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `mst_item_status`
--

CREATE TABLE IF NOT EXISTS `mst_item_status` (
  `item_status_id` char(3) collate utf8_unicode_ci NOT NULL,
  `item_status_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `rules` varchar(255) collate utf8_unicode_ci default NULL,
  `no_loan` smallint(1) NOT NULL default '0',
  `skip_stock_take` smallint(1) NOT NULL default '0',
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`item_status_id`),
  UNIQUE KEY `item_status_name` (`item_status_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mst_item_status`
--

INSERT INTO `mst_item_status` (`item_status_id`, `item_status_name`, `rules`, `input_date`, `last_update`) VALUES
('R', 'Repair', 'a:1:{i:0;s:1:"1";}', DATE(NOW()), DATE(NOW())),
('NL', 'No Loan', 'a:1:{i:0;s:1:"1";}', DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `mst_label`
--

CREATE TABLE IF NOT EXISTS `mst_label` (
  `label_id` int(11) NOT NULL auto_increment,
  `label_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `label_desc` varchar(50) collate utf8_unicode_ci default NULL,
  `label_image` varchar(200) collate utf8_unicode_ci NOT NULL,
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY  (`label_id`),
  UNIQUE KEY `label_name` (`label_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mst_label`
--

INSERT INTO `mst_label` (`label_id`, `label_name`, `label_desc`, `label_image`, `input_date`, `last_update`) VALUES
(1, 'label-new', 'New Title', 'label-new.png', DATE(NOW()), DATE(NOW())),
(2, 'label-favorite', 'Favorite Title', 'label-favorite.png', DATE(NOW()), DATE(NOW())),
(3, 'label-multimedia', 'Multimedia', 'label-multimedia.png', DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `mst_language`
--

CREATE TABLE IF NOT EXISTS `mst_language` (
  `language_id` char(5) collate utf8_unicode_ci NOT NULL,
  `language_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`language_id`),
  UNIQUE KEY `language_name` (`language_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mst_language`
--

INSERT INTO `mst_language` (`language_id`, `language_name`, `input_date`, `last_update`) VALUES
('id', 'Indonesia', DATE(NOW()), DATE(NOW())),
('en', 'English', DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `mst_loan_rules`
--

CREATE TABLE IF NOT EXISTS `mst_loan_rules` (
  `loan_rules_id` int(11) NOT NULL auto_increment,
  `member_type_id` int(11) NOT NULL default '0',
  `coll_type_id` int(11) default '0',
  `gmd_id` int(11) default '0',
  `loan_limit` int(3) default '0',
  `loan_periode` int(3) default '0',
  `reborrow_limit` int(3) default '0',
  `fine_each_day` int(3) default '0',
  `grace_periode` int(2) default '0',
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`loan_rules_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_loan_rules`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_location`
--

CREATE TABLE IF NOT EXISTS `mst_location` (
  `location_id` varchar(3) collate utf8_unicode_ci NOT NULL,
  `location_name` varchar(100) collate utf8_unicode_ci default NULL,
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY  (`location_id`),
  UNIQUE KEY `location_name` (`location_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mst_location`
--

INSERT INTO `mst_location` (`location_id`, `location_name`, `input_date`, `last_update`) VALUES
('SL', 'My Library', DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `mst_member_type`
--

CREATE TABLE IF NOT EXISTS `mst_member_type` (
  `member_type_id` int(11) NOT NULL auto_increment,
  `member_type_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `loan_limit` int(11) NOT NULL,
  `loan_periode` int(11) NOT NULL,
  `enable_reserve` int(1) NOT NULL default '0',
  `reserve_limit` int(11) NOT NULL default '0',
  `member_periode` int(11) NOT NULL,
  `reborrow_limit` int(11) NOT NULL,
  `fine_each_day` int(11) NOT NULL,
  `grace_periode` int(2) default '0',
  `input_date` date NOT NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`member_type_id`),
  UNIQUE KEY `member_type_name` (`member_type_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mst_member_type`
--

INSERT INTO `mst_member_type` (`member_type_id`, `member_type_name`, `loan_limit`, `loan_periode`, `enable_reserve`, `reserve_limit`, `member_periode`, `reborrow_limit`, `fine_each_day`, `grace_periode`, `input_date`, `last_update`) VALUES
(1, 'Standard', 2, 7, 1, 2, 365, 1, 0, 0, DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `mst_module`
--

CREATE TABLE IF NOT EXISTS `mst_module` (
  `module_id` int(3) NOT NULL auto_increment,
  `module_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `module_path` varchar(200) collate utf8_unicode_ci default NULL,
  `module_desc` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`module_id`),
  UNIQUE KEY `module_name` (`module_name`,`module_path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mst_module`
--

INSERT INTO `mst_module` (`module_id`, `module_name`, `module_path`, `module_desc`) VALUES
(1, 'bibliography', 'bibliography', 'Manage your bibliographic/catalog and items/copies database'),
(2, 'circulation', 'circulation', 'Module for doing library items circulation such as loan and return'),
(3, 'membership', 'membership', 'Manage your library membership and membership type'),
(4, 'master_file', 'master_file', 'Manage your referential data that will be used by other modules'),
(5, 'stock_take', 'stock_take', 'Ease your pain in doing library stock opname process'),
(6, 'system', 'system', 'Configure system behaviour, user and backups'),
(7, 'reporting', 'reporting', 'Real time and dynamic report about library collections and circulation'),
(8, 'serial_control', 'serial_control', 'Serial publication management');

-- --------------------------------------------------------

--
-- Table structure for table `mst_place`
--

CREATE TABLE IF NOT EXISTS `mst_place` (
  `place_id` int(11) NOT NULL auto_increment,
  `place_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`place_id`),
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
  `publisher_id` int(11) NOT NULL auto_increment,
  `publisher_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`publisher_id`),
  UNIQUE KEY `publisher_name` (`publisher_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_publisher`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_supplier`
--

CREATE TABLE IF NOT EXISTS `mst_supplier` (
  `supplier_id` int(11) NOT NULL auto_increment,
  `supplier_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `address` varchar(100) collate utf8_unicode_ci default NULL,
  `postal_code` char(10) collate utf8_unicode_ci default NULL,
  `phone` char(14) collate utf8_unicode_ci default NULL,
  `contact` char(30) collate utf8_unicode_ci default NULL,
  `fax` char(14) collate utf8_unicode_ci default NULL,
  `account` char(12) collate utf8_unicode_ci default NULL,
  `e_mail` char(80) collate utf8_unicode_ci default NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`supplier_id`),
  UNIQUE KEY `supplier_name` (`supplier_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_supplier`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_topic`
--

CREATE TABLE IF NOT EXISTS `mst_topic` (
  `topic_id` int(11) NOT NULL auto_increment,
  `topic` varchar(50) collate utf8_unicode_ci NOT NULL,
  `topic_type` enum('t','g','n','tm','gr','oc') collate utf8_unicode_ci NOT NULL,
  `auth_list` varchar(20) collate utf8_unicode_ci default NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`topic_id`),
  UNIQUE KEY `topic` (`topic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_topic`
--


-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE IF NOT EXISTS `reserve` (
  `reserve_id` int(11) NOT NULL auto_increment,
  `member_id` varchar(20) collate utf8_unicode_ci NOT NULL,
  `biblio_id` int(11) NOT NULL,
  `item_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `reserve_date` datetime NOT NULL,
  PRIMARY KEY  (`reserve_id`),
  KEY `references_idx` (`member_id`,`biblio_id`),
  KEY `item_code_idx` (`item_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reserve`
--


-- --------------------------------------------------------

--
-- Table structure for table `serial`
--

CREATE TABLE IF NOT EXISTS `serial` (
  `serial_id` int(11) NOT NULL auto_increment,
  `date_start` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `period` varchar(100) collate utf8_unicode_ci default NULL,
  `notes` text collate utf8_unicode_ci,
  `biblio_id` int(11) default NULL,
  `gmd_id` int(11) default NULL,
  `input_date` date NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY  (`serial_id`),
  KEY `fk_serial_biblio` (`biblio_id`),
  KEY `fk_serial_gmd` (`gmd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `serial`
--


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `setting_id` int(3) NOT NULL auto_increment,
  `setting_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `setting_value` text collate utf8_unicode_ci,
  PRIMARY KEY  (`setting_id`),
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'library_name', 's:7:"Senayan";'),
(2, 'library_subname', 's:37:"Open Source Library Management System";'),
(3, 'template', 'a:2:{s:5:"theme";s:7:"default";s:3:"css";s:26:"template/default/style.css";}'),
(4, 'admin_template', 'a:2:{s:5:"theme";s:7:"default";s:3:"css";s:32:"admin_template/default/style.css";}'),
(5, 'default_lang', 's:5:"en_US";'),
(6, 'opac_result_num', 's:2:"10";'),
(7, 'enable_promote_titles', 'N;'),
(8, 'quick_return', 'b:1;'),
(9, 'allow_loan_date_change', 'b:0;'),
(10, 'loan_limit_override', 'b:0;'),
(11, 'enable_xml_detail', 'b:1;'),
(12, 'enable_xml_result', 'b:1;'),
(13, 'allow_file_download', 'b:1;'),
(14, 'session_timeout', 's:4:"7200";');

-- --------------------------------------------------------

--
-- Table structure for table `stock_take`
--

CREATE TABLE IF NOT EXISTS `stock_take` (
  `stock_take_id` int(11) NOT NULL auto_increment,
  `stock_take_name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime default NULL,
  `init_user` varchar(50) collate utf8_unicode_ci NOT NULL,
  `total_item_stock_taked` int(11) default NULL,
  `total_item_lost` int(11) default NULL,
  `total_item_exists` int(11) default '0',
  `total_item_loan` int(11) default NULL,
  `stock_take_users` mediumtext collate utf8_unicode_ci,
  `is_active` int(1) NOT NULL default '0',
  `report_file` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`stock_take_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `stock_take`
--


-- --------------------------------------------------------

--
-- Table structure for table `stock_take_item`
--

CREATE TABLE IF NOT EXISTS `stock_take_item` (
  `stock_take_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `gmd_name` varchar(30) collate utf8_unicode_ci default NULL,
  `classification` varchar(30) collate utf8_unicode_ci default NULL,
  `coll_type_name` varchar(30) collate utf8_unicode_ci default NULL,
  `call_number` varchar(50) collate utf8_unicode_ci default NULL,
  `location` varchar(100) collate utf8_unicode_ci default NULL,
  `status` enum('e','m','u','l') collate utf8_unicode_ci NOT NULL default 'm',
  `checked_by` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_update` datetime default NULL,
  PRIMARY KEY  (`stock_take_id`,`item_id`),
  UNIQUE KEY `item_code` (`item_code`),
  KEY `status` (`status`),
  KEY `item_properties_idx` (`gmd_name`,`classification`,`coll_type_name`,`location`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_take_item`
--


-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE IF NOT EXISTS `system_log` (
  `log_id` int(11) NOT NULL auto_increment,
  `log_type` enum('staff','member','system') collate utf8_unicode_ci NOT NULL default 'staff',
  `id` varchar(50) collate utf8_unicode_ci default NULL,
  `log_location` varchar(50) collate utf8_unicode_ci NOT NULL,
  `log_msg` text collate utf8_unicode_ci NOT NULL,
  `log_date` datetime NOT NULL,
  PRIMARY KEY  (`log_id`),
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
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(50) collate utf8_unicode_ci NOT NULL,
  `realname` varchar(100) collate utf8_unicode_ci NOT NULL,
  `passwd` varchar(35) collate utf8_unicode_ci NOT NULL,
  `last_login` datetime default NULL,
  `last_login_ip` char(15) collate utf8_unicode_ci default NULL,
  `groups` varchar(200) collate utf8_unicode_ci default NULL,
  `input_date` date default '0000-00-00',
  `last_update` date default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `realname` (`realname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `realname`, `passwd`, `last_login`, `last_login_ip`, `groups`, `input_date`, `last_update`) VALUES
(1, 'admin', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', null, '127.0.0.1', 'a:1:{i:0;s:1:"1";}', DATE(NOW()), DATE(NOW()));

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `input_date` date default NULL,
  `last_update` date default NULL,
  PRIMARY KEY  (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`group_id`, `group_name`, `input_date`, `last_update`) VALUES
(1, 'Administrator', DATE(NOW()), DATE(NOW()));
