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

$menu[] = array('Header', __('System'));
// only administrator have privileges for below menus
if ($_SESSION['uid'] == 1) {
    $menu[] = array(__('System Configuration'), MODULES_WEB_ROOT_DIR.'system/index.php', __('Configure Global System Preferences'));
}
$menu[] = array(__('Content'), MODULES_WEB_ROOT_DIR.'system/content.php', __('Content'));
// only administrator have privileges for below menus
if ($_SESSION['uid'] == 1) {
    $menu[] = array(__('Biblio Indexes'), MODULES_WEB_ROOT_DIR.'system/biblio_indexes.php', __('Bibliographic Indexes management'));
    $menu[] = array(__('Modules'), MODULES_WEB_ROOT_DIR.'system/module.php', __('Configure Application Modules'));
    $menu[] = array(__('System Users'), MODULES_WEB_ROOT_DIR.'system/app_user.php', __('Manage Application User or Library Staff'));
    $menu[] = array(__('User Group'), MODULES_WEB_ROOT_DIR.'system/user_group.php', __('Manage Group of Application User'));
}
$menu[] = array(__('Holiday Setting'), MODULES_WEB_ROOT_DIR.'system/holiday.php', __('Configure Holiday Setting'));
$menu[] = array(__('Barcode Generator'), MODULES_WEB_ROOT_DIR.'system/barcode_generator.php', __('Barcode Generator'));
$menu[] = array(__('System Log'), MODULES_WEB_ROOT_DIR.'system/sys_log.php', __('View Application System Log'));
$menu[] = array(__('Database Backup'), MODULES_WEB_ROOT_DIR.'system/backup.php', __('Backup Application Database'));
?>
