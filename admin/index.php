<?php
/**
 * SENAYAN admin application bootstrap files
 *
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

// key to authenticate
define('INDEX_AUTH', '1');

// required file
require '../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
// session checking
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/template_parser/simbio_template_parser.inc.php';
require LIB_DIR.'module.inc.php';

// https connection (if enabled)
if ($sysconf['https_enable']) {
    simbio_security::doCheckHttps($sysconf['https_port']);
}

// create the template object
$template = new simbio_template_parser($sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'].'/index_template.html');
// page title
$page_title = $sysconf['library_name'].' :: Library Automation System';
// main menu
$module = new module();
$module->setModulesDir(MODULES_BASE_DIR);
$main_menu = $module->generateModuleMenu($dbs);

$current_module = '';
// get module from URL
if (isset($_GET['mod']) AND !empty($_GET['mod'])) {
    $current_module = trim($_GET['mod']);
}
// read privileges
$can_read = utility::havePrivilege($current_module, 'r');

// submenu
$sub_menu = $module->generateSubMenu(($current_module AND $can_read)?$current_module:'');

// start the output buffering for main content
ob_start();
// info
$info = __('Welcome To The Library Automation System, you are currently logged in as').' <strong>'.$_SESSION['realname'].'</strong>'; //mfc

if ($current_module AND $can_read) {
    // get content of module default content with AJAX
    $sysconf['page_footer'] .= "\n"
        .'<script type="text/javascript">'
        .'jQuery(document).ready(function() { jQuery(\'#mainContent\').simbioAJAX(\''.MODULES_WEB_ROOT_DIR.$current_module.'/index.php\', {method: \'get\'}); });'
        .'</script>';
} else {
    include 'default/home.php';
}
// page content
$main_content = ob_get_clean();

// assign content to markers
$template->assign('<!--PAGE_TITLE-->', $page_title);
$template->assign('<!--CSS-->', $sysconf['admin_template']['css']);
$template->assign('<!--MAIN_MENU-->', $main_menu);
$template->assign('<!--SUB_MENU-->', $sub_menu);
$template->assign('<!--INFO-->', $info);
$template->assign('<!--LIBRARY_NAME-->', $sysconf['library_name']);
$template->assign('<!--LIBRARY_SUBNAME-->', $sysconf['library_subname']);
$template->assign('<!--MAIN_CONTENT-->', $main_content);
$template->assign('<!--FOOTER-->', $sysconf['page_footer']);

// print out the template
$template->printOut();
?>
