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

$menu[] = array(lang_mod_report_other_recapitulation, MODULES_WEB_ROOT_DIR.'reporting/customs/class_recap.php', lang_mod_report_other_recapitulation_titletag);
$menu[] = array(lang_mod_report_other_titles, MODULES_WEB_ROOT_DIR.'reporting/customs/titles_list.php', lang_mod_report_other_titles_titletag);
$menu[] = array(lang_mod_report_other_itemtitles, MODULES_WEB_ROOT_DIR.'reporting/customs/item_titles_list.php', lang_mod_report_other_itemtitles_titletag);
$menu[] = array(lang_mod_report_other_itemusage, MODULES_WEB_ROOT_DIR.'reporting/customs/item_usage.php', lang_mod_report_other_itemusage_titletag);
$menu[] = array(lang_mod_report_other_loansclass, MODULES_WEB_ROOT_DIR.'reporting/customs/loan_by_class.php', lang_mod_report_other_loansclass_titletag);
$menu[] = array(lang_mod_report_other_memberlist, MODULES_WEB_ROOT_DIR.'reporting/customs/member_list.php', lang_mod_report_other_memberlist_titletag);
$menu[] = array(lang_mod_report_other_loanmember, MODULES_WEB_ROOT_DIR.'reporting/customs/member_loan_list.php', lang_mod_report_other_loanmember_titletag);
$menu[] = array(lang_mod_circ_transaction_history, MODULES_WEB_ROOT_DIR.'reporting/customs/loan_history.php', lang_mod_circ_transaction_history_titletag);
$menu[] = array(lang_mod_circ_overdues, MODULES_WEB_ROOT_DIR.'reporting/customs/overdued_list.php', lang_mod_circ_overdues_titletag);
$menu[] = array(lang_mod_report_other_staffactivity, MODULES_WEB_ROOT_DIR.'reporting/customs/staff_act.php', lang_mod_report_other_staffactivity_titletag);
?>
