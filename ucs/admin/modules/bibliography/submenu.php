<?php
/**
 * Copyright (C) 2010  Arie Nugraha (dicarve@yahoo.com)
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

$menu[] = array('Header', __('Bibliographic'));
$menu[] = array(__('Bibliographic List'), MODULES_WEB_ROOT_DIR.'bibliography/index.php', __('Show Existing Bibliographic Data'));
$menu[] = array('Header', __('Tools'));
$menu[] = array(__('Export Data'), MODULES_WEB_ROOT_DIR.'bibliography/export.php', __('Export Bibliographic Data To CSV format'));
$menu[] = array(__('Nodes Data Removal'), MODULES_WEB_ROOT_DIR.'bibliography/nodes_removal.php', __('Mass Nodes Data Removal'));
?>
