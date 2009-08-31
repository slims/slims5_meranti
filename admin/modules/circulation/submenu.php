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

$menu[] = array('Header', _('Circulation'));
$menu[] = array(_('Start Transaction'), MODULES_WEB_ROOT_DIR.'circulation/index.php?action=start', _('Start Circulation Transaction Proccess'));
$menu[] = array(_('Quick Return'), MODULES_WEB_ROOT_DIR.'circulation/quick_return.php', _('Quick Return Collection'));
$menu[] = array(_('Loan Rules'), MODULES_WEB_ROOT_DIR.'circulation/loan_rules.php', _('View and Modify Circulation Loan Rules'));
$menu[] = array(_('Loan History'), MODULES_WEB_ROOT_DIR.'reporting/customs/loan_history.php', _('Loan History Overview'));
$menu[] = array(_('Overdued List'), MODULES_WEB_ROOT_DIR.'reporting/customs/overdued_list.php', _('View Members Having Overdues'));
$menu[] = array(_('Reservation'), MODULES_WEB_ROOT_DIR.'reporting/customs/reserve_list.php', _('Reservation'));
?>
