<?php
/**
 *
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

/* Global application configuration */

if (!defined('UCS_BASE_DIR')) {
    // main system configuration
    require '../../../ucsysconfig.inc.php';
    // start the session
    require UCS_BASE_DIR.'admin/default/session.inc.php';
}

// only administrator have privileges to change global settings
if ($_SESSION['uid'] != 1) {
    header('Location: '.MODULES_WEB_ROOT_DIR.'system/content.php');
    die();
}

require UCS_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_directory.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

?>
<fieldset class="menuBox">
    <div class="menuBoxInner systemIcon">
        <?php echo strtoupper(__('System Configuration')).'<hr />'.__('Modify global application preferences'); ?>
    </div>
</fieldset>
<?php
/* main content */
/* Config Vars EDIT FORM */
/* Config Vars update process */

if (isset($_POST['updateData'])) {
    // reset/truncate setting table content
    // library name
    $library_name = $dbs->escape_string(strip_tags(trim($_POST['library_name'])));
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($library_name)).'\' WHERE setting_name=\'library_name\'');

    // library subname
    $library_subname = $dbs->escape_string(strip_tags(trim($_POST['library_subname'])));
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($library_subname)).'\' WHERE setting_name=\'library_subname\'');

    // initialize template arrays
    $template = array('theme' => $sysconf['template']['theme'], 'css' => $sysconf['template']['css']);

    // template
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($_POST['template'])).'\' WHERE setting_name=\'themes\'');

    // language
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($_POST['default_lang'])).'\' WHERE setting_name=\'default_lang\'');

    // opac num result
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($_POST['opac_result_num'])).'\' WHERE setting_name=\'opac_result_num\'');

    // xml detail
    $xml_detail = $_POST['enable_xml_detail'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($xml_detail)).'\' WHERE setting_name=\'enable_xml_detail\'');

    // xml result
    $xml_result = $_POST['enable_xml_result'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($xml_result)).'\' WHERE setting_name=\'enable_xml_result\'');

    // session timeout
    $session_timeout = intval($_POST['session_timeout']) >= 1800?$_POST['session_timeout']:1800;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($session_timeout)).'\' WHERE setting_name=\'session_timeout\'');

    // write log
    utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' change application global configuration');
    utility::jsAlert(__('Settings saved. Refreshing page'));
    echo '<script type="text/javascript">parent.location.href = \'../../index.php?mod=system\';</script>';
}
/* Config Vars update process end */

// create new instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'], 'post');
$form->submit_button_attr = 'name="updateData" value="'.__('Save Settings').'" class="button"';

// form table attributes
$form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

// load settings from database
utility::loadSettings($dbs);

// version status
$form->addAnything('UCS Version', '<strong>'.UCS_VERSION.'</strong>');

// library name
$form->addTextField('text', 'library_name', __('Library Name'), $sysconf['server']['name'], 'style="width: 100%;"');

// library subname
$form->addTextField('text', 'library_subname', __('Library Subname'), $sysconf['server']['subname'], 'style="width: 100%;"');

/* Form Element(s) */
// public template
// scan template directory
$template_dir = UCS_BASE_DIR.'themes';
$dir = new simbio_directory($template_dir);
$dir_tree = $dir->getDirectoryTree(1);
// sort array by index
ksort($dir_tree);
// loop array
foreach ($dir_tree as $dir) {
    $tpl_options[] = array($dir, $dir);
}
$form->addSelectList('template', __('OPAC Template'), $tpl_options, $sysconf['themes']);

// application language
require_once(INC_DIR.'localisation.php');
$form->addSelectList('default_lang', __('Default App. Language'), $available_languages, $sysconf['default_lang']);

// opac result list number
$result_num_options[] = array('10', '10');
$result_num_options[] = array('20', '20');
$result_num_options[] = array('30', '30');
$result_num_options[] = array('40', '40');
$result_num_options[] = array('50', '50');
$form->addSelectList('opac_result_num', __('Number Of Collections To Show In OPAC Result List'), $result_num_options, $sysconf['opac_result_num'] );

// enable bibliography xml detail
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('enable_xml_detail', __('OPAC XML Detail'), $options, $sysconf['enable_xml_detail']?'1':'0');

// enable bibliography xml result set
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('enable_xml_result', __('OPAC XML Result'), $options, $sysconf['enable_xml_result']?'1':'0');

// session timeout
$form->addTextField('text', 'session_timeout', __('Session Login Timeout'), $sysconf['session_timeout'], 'style="width: 10%;"');

// print out the object
echo $form->printOut();
/* main content end */
?>
