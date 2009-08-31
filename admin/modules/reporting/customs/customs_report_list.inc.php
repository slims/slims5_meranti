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

$menu[] = array(_('Custom Recapitulations'), MODULES_WEB_ROOT_DIR.'reporting/customs/class_recap.php', _('Title and Collection recapitulation based on classification and others'));
$menu[] = array(_('Title List'), MODULES_WEB_ROOT_DIR.'reporting/customs/titles_list.php', _('List of bibliographic titles'));
$menu[] = array(_('Items Title List'), MODULES_WEB_ROOT_DIR.'reporting/customs/item_titles_list.php', _('List of collection/items'));
$menu[] = array(_('Items Usage Statistics'), MODULES_WEB_ROOT_DIR.'reporting/customs/item_usage.php', _('List of Collection/items usage statistic'));
$menu[] = array(_('Loans by Classification'), MODULES_WEB_ROOT_DIR.'reporting/customs/loan_by_class.php', _('Loan statistic by classification'));
$menu[] = array(_('Member List'), MODULES_WEB_ROOT_DIR.'reporting/customs/member_list.php', _('List of library member/patron'));
$menu[] = array(_('Loan List by Member'), MODULES_WEB_ROOT_DIR.'reporting/customs/member_loan_list.php', _('List of loan by each member'));
$menu[] = array(_('Loan History'), MODULES_WEB_ROOT_DIR.'reporting/customs/loan_history.php', _('Loan History Overview'));
$menu[] = array(_('Overdued List'), MODULES_WEB_ROOT_DIR.'reporting/customs/overdued_list.php', _('View Members Having Overdues'));
$menu[] = array(_('Staff Activity'), MODULES_WEB_ROOT_DIR.'reporting/customs/staff_act.php', _('Staff activity log recapitulation'));
?>
