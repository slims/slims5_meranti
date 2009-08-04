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

/* Circulation module submenu items */

$menu[] = array('Header', lang_mod_circ);
$menu[] = array(lang_mod_circ_start, MODULES_WEB_ROOT_DIR.'circulation/index.php?action=start', lang_mod_circ_start_titletag);
$menu[] = array(lang_mod_circ_quick_return, MODULES_WEB_ROOT_DIR.'circulation/quick_return.php', lang_mod_circ_quick_return_titletag);
$menu[] = array(lang_mod_circ_loan_rules, MODULES_WEB_ROOT_DIR.'circulation/loan_rules.php', lang_mod_circ_loan_rules_titletag);
$menu[] = array(lang_mod_circ_transaction_history, MODULES_WEB_ROOT_DIR.'reporting/customs/loan_history.php', lang_mod_circ_transaction_history_titletag);
$menu[] = array(lang_mod_circ_overdues, MODULES_WEB_ROOT_DIR.'reporting/customs/overdued_list.php', lang_mod_circ_overdues_titletag);
$menu[] = array(lang_mod_circ_reserve, MODULES_WEB_ROOT_DIR.'reporting/customs/reserve_list.php', lang_mod_circ_reserve);
?>
