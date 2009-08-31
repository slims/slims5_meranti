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

$menu[] = array('Header', _('Bibliographic'));
$menu[] = array(_('Bibliographic List'), MODULES_WEB_ROOT_DIR.'bibliography/index.php', _('Show Existing Bibliographic Data'));
$menu[] = array(_('Add New Bibliography'), MODULES_WEB_ROOT_DIR.'bibliography/index.php?action=detail', _('Add New Bibliographic Data/Catalog'));
$menu[] = array('Header', _('Items'));
$menu[] = array(_('Item List'), MODULES_WEB_ROOT_DIR.'bibliography/item.php', _('Show List of Library Items'));
$menu[] = array(_('Checkout Items'), MODULES_WEB_ROOT_DIR.'bibliography/checkout_item.php', _('Show List of Checkout Items'));
$menu[] = array('Header', _('Tools'));
$menu[] = array(_('Z3950 Service'), MODULES_WEB_ROOT_DIR.'bibliography/z3950.php', _('Grab Bibliographic Data from Z3950 Web Services'));
$menu[] = array(_('Labels Printing'), MODULES_WEB_ROOT_DIR.'bibliography/dl_print.php', _('Print Document Labels'));
$menu[] = array(_('Item Barcodes Printing'), MODULES_WEB_ROOT_DIR.'bibliography/item_barcode_generator.php', _('Print Item Barcodes'));
$menu[] = array(_('Import Data'), MODULES_WEB_ROOT_DIR.'bibliography/import.php', _('Import Data to Bibliographic Database from CSV file'));
$menu[] = array(_('Export Data'), MODULES_WEB_ROOT_DIR.'bibliography/export.php', _('Export Bibliographic Data To CSV format'));
?>
