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

$menu[] = array('Header', _('Authority Files'));
$menu[] = array(_('GMD'), MODULES_WEB_ROOT_DIR.'master_file/index.php', _('General Material Designation'));
$menu[] = array(_('Publisher'), MODULES_WEB_ROOT_DIR.'master_file/publisher.php', _('Document Publisher'));
$menu[] = array(_('Supplier'), MODULES_WEB_ROOT_DIR.'master_file/supplier.php', _('Item Supplier'));
$menu[] = array(_('Author'), MODULES_WEB_ROOT_DIR.'master_file/author.php', _('Document Authors'));
$menu[] = array(_('Subject'), MODULES_WEB_ROOT_DIR.'master_file/topic.php', _('Subject'));
$menu[] = array(_('Location'), MODULES_WEB_ROOT_DIR.'master_file/location.php', _('Item Location'));
$menu[] = array('Header', _('Lookup Files'));
$menu[] = array(_('Place'), MODULES_WEB_ROOT_DIR.'master_file/place.php', _('Place Name'));
$menu[] = array(_('Item Status'), MODULES_WEB_ROOT_DIR.'master_file/item_status.php', _('Item Status'));
$menu[] = array(_('Collection Type'), MODULES_WEB_ROOT_DIR.'master_file/coll_type.php', _('Collection Type'));
$menu[] = array(_('Doc. Language'), MODULES_WEB_ROOT_DIR.'master_file/doc_language.php', _('Document Content Language'));
$menu[] = array(_('Label'), MODULES_WEB_ROOT_DIR.'master_file/label.php', _('Special Labels for Titles to Show Up On Homepage'));
$menu[] = array(_('Frequency'), MODULES_WEB_ROOT_DIR.'master_file/frequency.php', _('Frequency'));
?>
