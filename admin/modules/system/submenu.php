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

/* Membership module submenu items */

$menu[] = array('Header', lang_sys_mod);
$menu[] = array(lang_sys_configuration, MODULES_WEB_ROOT_DIR.'system/index.php', lang_sys_configuration_titletag);
$menu[] = array(lang_sys_content, MODULES_WEB_ROOT_DIR.'system/content.php', lang_sys_content_titletag);
$menu[] = array(lang_sys_modules, MODULES_WEB_ROOT_DIR.'system/module.php', lang_sys_modules_titletag);
$menu[] = array(lang_sys_user, MODULES_WEB_ROOT_DIR.'system/app_user.php', lang_sys_user_titletag);
$menu[] = array(lang_sys_group, MODULES_WEB_ROOT_DIR.'system/user_group.php', lang_sys_group_titletag);
$menu[] = array(lang_sys_holiday, MODULES_WEB_ROOT_DIR.'system/holiday.php', lang_sys_holiday_titletag);
$menu[] = array(lang_sys_barcodes, MODULES_WEB_ROOT_DIR.'system/barcode_generator.php', lang_sys_barcodes_titletag);
$menu[] = array(lang_sys_syslog, MODULES_WEB_ROOT_DIR.'system/sys_log.php', lang_sys_syslog_titletag);
$menu[] = array(lang_sys_backup, MODULES_WEB_ROOT_DIR.'system/backup.php', lang_sys_backup_titletag);
?>
