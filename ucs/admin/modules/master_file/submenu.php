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

/* Master File module submenu items */

$menu[] = array('Header', __('Authority Files'));
$menu[] = array(__('GMD'), MODULES_WEB_ROOT_DIR.'master_file/index.php', __('General Material Designation'));
$menu[] = array(__('Publisher'), MODULES_WEB_ROOT_DIR.'master_file/publisher.php', __('Document Publisher'));
$menu[] = array(__('Author'), MODULES_WEB_ROOT_DIR.'master_file/author.php', __('Document Authors'));
$menu[] = array(__('Subject'), MODULES_WEB_ROOT_DIR.'master_file/topic.php', __('Subject'));
$menu[] = array(__('Place'), MODULES_WEB_ROOT_DIR.'master_file/place.php', __('Place Name'));
$menu[] = array(__('Doc. Language'), MODULES_WEB_ROOT_DIR.'master_file/doc_language.php', __('Document Content Language'));
$menu[] = array(__('Frequency'), MODULES_WEB_ROOT_DIR.'master_file/frequency.php', __('Frequency'));
?>
