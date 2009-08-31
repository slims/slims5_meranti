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

$menu[] = array('Header', _('System'));
$menu[] = array(_('System Configuration'), MODULES_WEB_ROOT_DIR.'system/index.php', _('Configure Global System Preferences'));
$menu[] = array(_('Content'), MODULES_WEB_ROOT_DIR.'system/content.php', _('Content'));
$menu[] = array(_('Modules'), MODULES_WEB_ROOT_DIR.'system/module.php', _('Configure Application Modules'));
$menu[] = array(_('System Users'), MODULES_WEB_ROOT_DIR.'system/app_user.php', _('Manage Application User or Library Staff'));
$menu[] = array(_('User Group'), MODULES_WEB_ROOT_DIR.'system/user_group.php', _('Manage Group of Application User'));
$menu[] = array(_('Holiday Setting'), MODULES_WEB_ROOT_DIR.'system/holiday.php', _('Configure Holiday Setting'));
$menu[] = array(_('Barcode Generator'), MODULES_WEB_ROOT_DIR.'system/barcode_generator.php', _('Barcode Generator'));
$menu[] = array(_('System Log'), MODULES_WEB_ROOT_DIR.'system/sys_log.php', _('View Application System Log'));
$menu[] = array(_('Database Backup'), MODULES_WEB_ROOT_DIR.'system/backup.php', _('Backup Application Database'));
?>
