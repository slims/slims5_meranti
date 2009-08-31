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

$menu[] = array('Header', _('Membership'));
$menu[] = array(_('View Member List'), MODULES_WEB_ROOT_DIR.'membership/index.php', _('View Library Member List'));
$menu[] = array(_('Add New Member'), MODULES_WEB_ROOT_DIR.'membership/index.php?action=detail', _('Add New Library Member Data'));
$menu[] = array(_('Member Type'), MODULES_WEB_ROOT_DIR.'membership/member_type.php', _('View and modify member type'));
$menu[] = array('Header', _('Tools'));
$menu[] = array(_('Member Card Printing'), MODULES_WEB_ROOT_DIR.'membership/member_card_generator.php', _('Print Member Card'));
$menu[] = array(_('Import Data'), MODULES_WEB_ROOT_DIR.'membership/import.php', _('Import Members Data From CSV File'));
$menu[] = array(_('Export Data'), MODULES_WEB_ROOT_DIR.'membership/export.php', _('Export Members Data To CSV File'));
?>
