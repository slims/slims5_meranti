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

/* Stock Take module submenu items */

$menu[] = array('Header', _('Stock Take'));
$menu[] = array(_('Stock Take History'), MODULES_WEB_ROOT_DIR.'stock_take/index.php', _('View Stock Take History'));
// check if there is any active stock take proccess
$stk_query = $dbs->query('SELECT * FROM stock_take WHERE is_active=1');
if ($stk_query->num_rows) {
    $menu[] = array(_('Current Stock Take'), MODULES_WEB_ROOT_DIR.'stock_take/current.php', _('View Current Stock Take Process'));
    $menu[] = array(_('Stock Take Report'), MODULES_WEB_ROOT_DIR.'stock_take/st_report.php', _('View Current Stock Take Report'));
    $menu[] = array(_('Finish Stock Take'), MODULES_WEB_ROOT_DIR.'stock_take/finish.php', _('Finish Current Stock Take Proccess'));
    $menu[] = array(_('Current Lost Item'), MODULES_WEB_ROOT_DIR.'stock_take/lost_item_list.php', _('View Lost Item in Current Stock Take Proccess'));
    $menu[] = array(_('Stock Take Log'), MODULES_WEB_ROOT_DIR.'stock_take/st_log.php', _('View Log of Current Stock Take Proccess'));
    $menu[] = array(_('Resynchronize'), MODULES_WEB_ROOT_DIR.'stock_take/resync.php', _('Resynchronize bibliographic data with current stock take'));
    $menu[] = array(_('Upload List'), MODULES_WEB_ROOT_DIR.'stock_take/st_upload.php', _('Upload List in text file'));
} else {
    $menu[] = array(_('Initialize'), MODULES_WEB_ROOT_DIR.'stock_take/init.php', _('Initialize New Stock Take Proccess'));
}
?>
