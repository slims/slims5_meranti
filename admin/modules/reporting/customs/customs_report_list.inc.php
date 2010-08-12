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

// be sure that this file not accessed directly
if (INDEX_AUTH != 1) { 
    die("can not access this file directly");
}

/* Custom reports list */

$menu[] = array(__('Custom Recapitulations'), MODULES_WEB_ROOT_DIR.'reporting/customs/class_recap.php', __('Title and Collection recapitulation based on classification and others'));
$menu[] = array(__('Title List'), MODULES_WEB_ROOT_DIR.'reporting/customs/titles_list.php', __('List of bibliographic titles'));
$menu[] = array(__('Items Title List'), MODULES_WEB_ROOT_DIR.'reporting/customs/item_titles_list.php', __('List of collection/items'));
$menu[] = array(__('Items Usage Statistics'), MODULES_WEB_ROOT_DIR.'reporting/customs/item_usage.php', __('List of Collection/items usage statistic'));
$menu[] = array(__('Loans by Classification'), MODULES_WEB_ROOT_DIR.'reporting/customs/loan_by_class.php', __('Loan statistic by classification'));
$menu[] = array(__('Member List'), MODULES_WEB_ROOT_DIR.'reporting/customs/member_list.php', __('List of library member/patron'));
$menu[] = array(__('Loan List by Member'), MODULES_WEB_ROOT_DIR.'reporting/customs/member_loan_list.php', __('List of loan by each member'));
$menu[] = array(__('Loan History'), MODULES_WEB_ROOT_DIR.'reporting/customs/loan_history.php', __('Loan History Overview'));
$menu[] = array(__('Due Date Warning'), MODULES_WEB_ROOT_DIR.'reporting/customs/due_date_warning.php', __('Loan Due Date Warnings'));
$menu[] = array(__('Overdued List'), MODULES_WEB_ROOT_DIR.'reporting/customs/overdued_list.php', __('View Members Having Overdues'));
$menu[] = array(__('Staff Activity'), MODULES_WEB_ROOT_DIR.'reporting/customs/staff_act.php', __('Staff activity log recapitulation'));
$menu[] = array(__('Visitor Statistic'), MODULES_WEB_ROOT_DIR.'reporting/customs/visitor_report.php', __('Visitor Statistic'));
$menu[] = array(__('Visitor Statistic (by Day)'), MODULES_WEB_ROOT_DIR.'reporting/customs/visitor_report_day.php', __('Visitor Statistic (by Day)'));
$menu[] = array(__('Visitor List'), MODULES_WEB_ROOT_DIR.'reporting/customs/visitor_list.php', __('Visitor List'));
$menu[] = array(__('Fines Report'), MODULES_WEB_ROOT_DIR.'reporting/customs/fines_report.php', __('Fines Report'));
?>
