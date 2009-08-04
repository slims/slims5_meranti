<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/* Master File module submenu items */

$menu[] = array('Header', lang_mod_masterfile_authority_files);
$menu[] = array(lang_mod_masterfile_gmd, MODULES_WEB_ROOT_DIR.'master_file/index.php', lang_mod_masterfile_gmd_titletag);
$menu[] = array(lang_mod_masterfile_publisher, MODULES_WEB_ROOT_DIR.'master_file/publisher.php', lang_mod_masterfile_publisher_titletag);
$menu[] = array(lang_mod_masterfile_supplier, MODULES_WEB_ROOT_DIR.'master_file/supplier.php', lang_mod_masterfile_supplier_titletag);
$menu[] = array(lang_mod_masterfile_author, MODULES_WEB_ROOT_DIR.'master_file/author.php', lang_mod_masterfile_author_titletag);
$menu[] = array(lang_mod_masterfile_topic, MODULES_WEB_ROOT_DIR.'master_file/topic.php', lang_mod_masterfile_topic_titletag);
$menu[] = array(lang_mod_masterfile_location, MODULES_WEB_ROOT_DIR.'master_file/location.php', lang_mod_masterfile_location_titletag);
$menu[] = array('Header', lang_mod_masterfile_lookup_files);
$menu[] = array(lang_mod_masterfile_place, MODULES_WEB_ROOT_DIR.'master_file/place.php', lang_mod_masterfile_place_titletag);
$menu[] = array(lang_mod_masterfile_itemstatus_titletag, MODULES_WEB_ROOT_DIR.'master_file/item_status.php', lang_mod_masterfile_itemstatus_titletag);
$menu[] = array(lang_mod_masterfile_colltype, MODULES_WEB_ROOT_DIR.'master_file/coll_type.php', lang_mod_masterfile_colltype_titletag);
$menu[] = array(lang_mod_masterfile_lang, MODULES_WEB_ROOT_DIR.'master_file/doc_language.php', lang_mod_masterfile_lang_titletag);
$menu[] = array(lang_mod_masterfile_label, MODULES_WEB_ROOT_DIR.'master_file/label.php', lang_mod_masterfile_label_titletag);
$menu[] = array(lang_mod_masterfile_frequency, MODULES_WEB_ROOT_DIR.'master_file/frequency.php', lang_mod_masterfile_frequency_titletag);
?>
