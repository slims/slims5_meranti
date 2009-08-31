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

$menu[] = array('Header', __('Membership'));
$menu[] = array(__('View Member List'), MODULES_WEB_ROOT_DIR.'membership/index.php', __('View Library Member List'));
$menu[] = array(__('Add New Member'), MODULES_WEB_ROOT_DIR.'membership/index.php?action=detail', __('Add New Library Member Data'));
$menu[] = array(__('Member Type'), MODULES_WEB_ROOT_DIR.'membership/member_type.php', __('View and modify member type'));
$menu[] = array('Header', __('Tools'));
$menu[] = array(__('Member Card Printing'), MODULES_WEB_ROOT_DIR.'membership/member_card_generator.php', __('Print Member Card'));
$menu[] = array(__('Import Data'), MODULES_WEB_ROOT_DIR.'membership/import.php', __('Import Members Data From CSV File'));
$menu[] = array(__('Export Data'), MODULES_WEB_ROOT_DIR.'membership/export.php', __('Export Members Data To CSV File'));
?>
