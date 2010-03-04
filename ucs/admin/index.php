<?php
/**
 * SENAYAN admin application bootstrap files
 *
 * Copyright (C) 2009  Arie Nugraha (dicarve@yahoo.com)
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

// required file
require '../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
// session checking
require UCS_BASE_DIR.'admin/default/session_check.inc.php';
require LIB_DIR.'module.inc.php';

// https connection (if enabled)
if ($sysconf['https_enable']) {
    simbio_security::doCheckHttps($sysconf['https_port']);
}

// page title
$page_title = $sysconf['server']['name'].' :: UCS Administration';
// main menu
$module = new module();
$module->setModulesDir(MODULES_BASE_DIR);
$main_menu = $module->generateModuleMenu($dbs);

$current_module = '';
// get module from URL
if (isset($_GET['mod']) && !empty($_GET['mod'])) {
    $current_module = trim($_GET['mod']);
}
// read privileges
$can_read = utility::havePrivilege($current_module, 'r');

// submenu
$sub_menu = $module->generateSubMenu(($current_module AND $can_read)?$current_module:'');

// start the output buffering for main content
ob_start();
// info
$info = __('Union Catalog Server administration console. you are currently logged in as').' <strong>'.$_SESSION['realname'].'</strong>'; //mfc
// set some javascript vars
echo '<script type="text/javascript">';
if ($current_module) {
    echo 'defaultAJAXurl = \''.MODULES_WEB_ROOT_DIR.$current_module.'/index.php\';';
} else {
    echo 'defaultAJAXurl = \''.UCS_WEB_ROOT_DIR.'admin/default/home.php\';';
}
echo '</script>';

if ($current_module && $can_read) {
    // get content of module default content with AJAX
    $sysconf['page_footer'] .= "\n"
        .'<script type="text/javascript">'
        .'Event.observe(window, \'load\', function() { lastStr = \''.addslashes($info).'\'; registerAdminEvents(); setContent(\'mainContent\', \''.MODULES_WEB_ROOT_DIR.$current_module.'/index.php\', \'get\') });'
        .'</script>';
} else {
    include 'default/home.php';
    $sysconf['page_footer'] .= "\n"
        .'<script type="text/javascript">Event.observe(window, \'load\', function() { lastStr = \''.addslashes($info).'\'; registerAdminEvents(); });</script>';
}
// page content
$main_content = ob_get_clean();

// template output
require ADMIN_THEMES_BASE_DIR.'default'.DSEP.'index_template.inc.php';
?>
