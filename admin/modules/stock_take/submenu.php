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

$menu[] = array('Header', lang_mod_stocktake);
$menu[] = array(lang_mod_stocktake_history, MODULES_WEB_ROOT_DIR.'stock_take/index.php', lang_mod_stocktake_history_titletag);
// check if there is any active stock take proccess
$stk_query = $dbs->query('SELECT * FROM stock_take WHERE is_active=1');
if ($stk_query->num_rows) {
    $menu[] = array(lang_mod_stocktake_current, MODULES_WEB_ROOT_DIR.'stock_take/current.php', lang_mod_stocktake_current_titletag);
    $menu[] = array(lang_mod_stocktake_report, MODULES_WEB_ROOT_DIR.'stock_take/st_report.php', lang_mod_stocktake_report_titletag);
    $menu[] = array(lang_mod_stocktake_finish, MODULES_WEB_ROOT_DIR.'stock_take/finish.php', lang_mod_stocktake_finish_titletag);
    $menu[] = array(lang_mod_stocktake_lost, MODULES_WEB_ROOT_DIR.'stock_take/lost_item_list.php', lang_mod_stocktake_lost_titletag);
    $menu[] = array(lang_mod_stocktake_log, MODULES_WEB_ROOT_DIR.'stock_take/st_log.php', lang_mod_stocktake_log_titletag);
    $menu[] = array(lang_mod_stocktake_resync, MODULES_WEB_ROOT_DIR.'stock_take/resync.php', lang_mod_stocktake_resync_titletag);
    $menu[] = array(lang_mod_stocktake_upload, MODULES_WEB_ROOT_DIR.'stock_take/st_upload.php', lang_mod_stocktake_upload_titletag);
} else {
    $menu[] = array(lang_mod_stocktake_init, MODULES_WEB_ROOT_DIR.'stock_take/init.php', lang_mod_stocktake_init_titletag);
}
?>
