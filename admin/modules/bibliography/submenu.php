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

/* Bibliographic module submenu items */

$menu[] = array('Header', lang_mod_biblio);
$menu[] = array(lang_mod_biblio_list, MODULES_WEB_ROOT_DIR.'bibliography/index.php', lang_mod_biblio_list_titletag);
$menu[] = array(lang_mod_biblio_add, MODULES_WEB_ROOT_DIR.'bibliography/index.php?action=detail', lang_mod_biblio_add_titletag);
$menu[] = array('Header', lang_mod_biblio_item);
$menu[] = array(lang_mod_biblio_item_list, MODULES_WEB_ROOT_DIR.'bibliography/item.php', lang_mod_biblio_item_list_titletag);
$menu[] = array(lang_mod_biblio_item_checkout, MODULES_WEB_ROOT_DIR.'bibliography/checkout_item.php', lang_mod_biblio_item_checkout_titletag);
$menu[] = array('Header', lang_sys_common_tools);
$menu[] = array(lang_mod_biblio_tools_z3950, MODULES_WEB_ROOT_DIR.'bibliography/z3950.php', lang_mod_biblio_tools_z3950_titletag);
$menu[] = array(lang_mod_biblio_tools_label_print, MODULES_WEB_ROOT_DIR.'bibliography/dl_print.php', lang_mod_biblio_tools_label_print_titletag);
$menu[] = array(lang_mod_biblio_tools_item_barcode, MODULES_WEB_ROOT_DIR.'bibliography/item_barcode_generator.php', lang_mod_biblio_tools_item_barcode_titletag);
$menu[] = array(lang_mod_biblio_tools_import, MODULES_WEB_ROOT_DIR.'bibliography/import.php', lang_mod_biblio_tools_import_titletag);
$menu[] = array(lang_mod_biblio_tools_export, MODULES_WEB_ROOT_DIR.'bibliography/export.php', lang_mod_biblio_tools_export_titletag);
?>
