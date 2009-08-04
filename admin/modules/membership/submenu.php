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

$menu[] = array('Header', lang_mod_membership);
$menu[] = array(lang_mod_membership_view_member_list, MODULES_WEB_ROOT_DIR.'membership/index.php', lang_mod_membership_view_member_list_titletag);
$menu[] = array(lang_mod_membership_add_new_member, MODULES_WEB_ROOT_DIR.'membership/index.php?action=detail', lang_mod_membership_add_new_member_titletag);
$menu[] = array(lang_mod_membership_member_type, MODULES_WEB_ROOT_DIR.'membership/member_type.php', lang_mod_membership_member_type_titletag);
$menu[] = array('Header', lang_sys_common_tools);
$menu[] = array(lang_mod_membership_card_generator, MODULES_WEB_ROOT_DIR.'membership/member_card_generator.php', lang_mod_membership_card_generator_titletag);
$menu[] = array(lang_mod_membership_import_data, MODULES_WEB_ROOT_DIR.'membership/import.php', lang_mod_membership_import_data_titletag);
$menu[] = array(lang_mod_membership_export_data, MODULES_WEB_ROOT_DIR.'membership/export.php', lang_mod_membership_export_data_titletag);
?>
