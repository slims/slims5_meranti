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

$menu[] = array('Header', lang_mod_default_home_panel);
$menu[] = array(lang_mod_default_home_user_profile, MODULES_WEB_ROOT_DIR.'system/app_user.php?changecurrent=true&action=detail', lang_mod_default_home_user_profile_titletag);
if (utility::havePrivilege('bibliography', 'r') AND utility::havePrivilege('bibliography', 'w')) {
    $menu[] = array(lang_mod_biblio_add, MODULES_WEB_ROOT_DIR.'bibliography/index.php?action=detail', lang_mod_biblio_add_titletag);
}
if (utility::havePrivilege('circulation', 'r') AND utility::havePrivilege('circulation', 'w')) {
    $menu[] = array(lang_mod_circ_start, MODULES_WEB_ROOT_DIR.'circulation/index.php?action=start', lang_mod_circ_start_titletag);
}
if (utility::havePrivilege('circulation', 'r') AND utility::havePrivilege('circulation', 'w')) {
    $menu[] = array(lang_mod_circ_quick_return, MODULES_WEB_ROOT_DIR.'circulation/quick_return.php', lang_mod_circ_quick_return_titletag);
}
if (utility::havePrivilege('membership', 'r') AND utility::havePrivilege('membership', 'w')) {
    $menu[] = array(lang_mod_membership_add_new_member, MODULES_WEB_ROOT_DIR.'membership/index.php?action=new', lang_mod_membership_add_new_member_titletag);
}
?>
