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


/* Biblio Item List */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';

// ajax action
$content = '<script type="text/javascript">'."\n";
if (isset($_GET['itemID']) AND isset($_GET['action'])) {
    $itemID = (integer)$_GET['itemID'];
    $itemCollID = (integer)$_GET['itemCollID'];
    $content .= 'Event.observe(window, \'load\', function() { setContent(\'pageContent\', \'index.php?inPopUp=true&action=detail\', \'post\', \'itemID='.$itemID.'&itemCollID='.$itemCollID.'&detail=true\', true); })';
}
$content .= '</script>';

// page title
$page_title = 'Bibliographic Data';
// include the page template
require UCS_BASE_DIR.'/admin/admin_themes/notemplate_page_tpl.php';
?>
