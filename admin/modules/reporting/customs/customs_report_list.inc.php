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

/* Custom reports list */

$menu[] = array('Class Recap', MODULES_WEB_ROOT_DIR.'reporting/customs/class_recap.php', 'Title and Collection recapitulation based on classification and others');
$menu[] = array('Titles', MODULES_WEB_ROOT_DIR.'reporting/customs/titles_list.php', 'List of bibliographic titles');
$menu[] = array('Items Title List', MODULES_WEB_ROOT_DIR.'reporting/customs/item_titles_list.php', 'List of collection/items');
$menu[] = array('Items Usage', MODULES_WEB_ROOT_DIR.'reporting/customs/item_usage.php', 'List of Collection/items usage statistic');
$menu[] = array('Loan By Class', MODULES_WEB_ROOT_DIR.'reporting/customs/loan_by_class.php', 'Loan statistic by classification');
$menu[] = array('Member List', MODULES_WEB_ROOT_DIR.'reporting/customs/member_list.php', 'List of library member/patron');
$menu[] = array('Member Loan List', MODULES_WEB_ROOT_DIR.'reporting/customs/member_loan_list.php', 'List of loan by each member');
$menu[] = array(lang_mod_circ_transaction_history, MODULES_WEB_ROOT_DIR.'reporting/customs/loan_history.php', 'History of  circulation');
$menu[] = array(lang_mod_circ_overdues, MODULES_WEB_ROOT_DIR.'reporting/customs/overdued_list.php', 'List of overdued collection');
$menu[] = array('Staff Activity', MODULES_WEB_ROOT_DIR.'reporting/customs/staff_act.php', 'Staff activity log recapitulation');
?>
