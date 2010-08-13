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


/* Biblio Item List */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';

// ajax action
$content = '<script type="text/javascript">'."\n";
if (isset($_GET['itemID']) AND isset($_GET['action'])) {
    $itemID = (integer)$_GET['itemID'];
    $itemCollID = (integer)$_GET['itemCollID'];
    $content .= '$(document).ready(function() { $(\'#pageContent\').simbioAJAX(\'index.php?inPopUp=true&action=detail\', {method: \'POST\', addData: \'itemID='.$itemID.'&itemCollID='.$itemCollID.'&detail=true\'}); })';
}
$content .= '</script>';

// page title
$page_title = 'Bibliographic Data';
// include the page template
require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
?>
