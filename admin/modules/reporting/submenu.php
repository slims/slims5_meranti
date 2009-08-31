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

/* Reporting module submenu items */

$menu[] = array('Header', _('Reporting'));
$menu[] = array(_('Collection Statistic'), MODULES_WEB_ROOT_DIR.'reporting/index.php', _('View Library Collection Statistic'));
$menu[] = array(_('Loan Report'), MODULES_WEB_ROOT_DIR.'reporting/loan_report.php', _('View Library Loan Report'));
$menu[] = array(_('Membership Report'), MODULES_WEB_ROOT_DIR.'reporting/member_report.php', _('View Membership Report'));
$menu[] = array('Header', _('Other Reports'));
// other/custom report menu
require MODULES_BASE_DIR.'reporting/customs/customs_report_list.inc.php';
?>
