<?php
/**
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

/* Barcode generator section */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/template_parser/simbio_template_parser.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';

// privileges checking
$can_read = utility::havePrivilege('system', 'r');
$can_write = utility::havePrivilege('system', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}

$max_print = 50;

// barcode pdf download
if (isset($_SESSION['barcodes'])) {
    // include printed settings configuration file
    require SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.'admin_template'.DIRECTORY_SEPARATOR.'printed_settings.inc.php';
    // check for custom template settings
    $custom_settings = SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.$sysconf['admin_template']['dir'].DIRECTORY_SEPARATOR.$sysconf['template']['theme'].DIRECTORY_SEPARATOR.'printed_settings.inc.php';
    if (file_exists($custom_settings)) {
        include $custom_settings;
    }
    // chunk barcode array
    $chunked_barcode_arrays = array_chunk($_SESSION['barcodes'], $items_per_row);
    // create html ouput
    $html_str = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
    $html_str .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>Document Label Print Result</title>'."\n";
    $html_str .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    $html_str .= '<meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0" /><meta http-equiv="Expires" content="Sat, 26 Jul 1997 05:00:00 GMT" />';
    $html_str .= '<style type="text/css">'."\n";
    $html_str .= 'body { padding: 0; overflow: auto; background: #fff; }'."\n";
    $html_str .= '.labelStyle { text-align: center; float: left; margin: '.$barcodegen_items_margin.'cm; border: '.($barcodegen_include_border>0?$barcodegen_include_border:0).'px solid #000000; }'."\n";
    $html_str .= '</style>'."\n";
    $html_str .= '</head>'."\n";
    $html_str .= '<body>'."\n";
    // loop the chunked arrays to row
    foreach ($chunked_barcode_arrays as $barcode_rows) {
        $html_str .= '<div style="clear: both;">';
        foreach ($barcode_rows as $barcode) {
            $html_str .= '<div class="labelStyle">';
            $html_str .= '<img src="'.SENAYAN_WEB_ROOT_DIR.'images/barcodes/'.str_replace(array(' '), '_', $barcode).'.png" style="width: 90%" border="0" />';
            $html_str .= '</div>';
        }
        $html_str .= '</div>';
    }
    $html_str .= '<script type="text/javascript">self.print();</script>'."\n";
    $html_str .= '</body></html>'."\n";
    // unset the session
    unset($_SESSION['barcodes']);
    // write to file
    $print_file_name = 'barcode_gen_print_result_'.strtolower(str_replace(' ', '_', $_SESSION['uname'])).'.html';
    $file_write = @file_put_contents(FILES_UPLOAD_DIR.$print_file_name, $html_str);
    if ($file_write) {
        // open result in window
        echo '<script type="text/javascript">top.openHTMLpop(\''.SENAYAN_WEB_ROOT_DIR.FILES_DIR.'/'.$print_file_name.'\', 800, 500, \''.__('Barcode Generator').'\')</script>';
    } else { utility::jsAlert('ERROR! Barcodes failed to generate, possibly because '.SENAYAN_BASE_DIR.FILES_DIR.' directory is not writable'); }
    exit();
}

// barcodes generator proccess
if (isset($_POST['saveData']) AND $can_write) {
    if (count($_POST['barcode']) > 0) {
        $size = intval($_POST['size']);
        // create AJAX request
        echo '<script type="text/javascript" src="'.JS_WEB_ROOT_DIR.'prototype.js"></script>';
        echo '<script type="text/javascript">';
        foreach ($_POST['barcode'] as $barcode_text) {
            if (!empty($barcode_text)) {
                $barcode_text = trim($barcode_text);
                echo '$.ajax({url: \''.SENAYAN_WEB_ROOT_DIR.'lib/phpbarcode/barcode.php?code='.$barcode_text.'&encoding='.$sysconf['barcode_encoding'].'&scale='.$size.'&mode=png\', type: \'GET\', error: function() { alert(\''.__('Error creating barcode!').'\'); } });'."\n";
                // add to sessions
                $_SESSION['barcodes'][] = $barcode_text;
            }
        }
        echo 'alert(\''.__('Barcode generation finished').'\')'."\n";
        echo 'location.href = \''.$_SERVER['PHP_SELF'].'\''."\n";
        echo '</script>';
    }
    exit();
}

?>
<fieldset class="menuBox">
<div class="menuBoxInner barcodeIcon">
    <?php echo __('Barcode Generator').' <hr />' . __('Type barcodes text to one or more text field below and click'). ' "' .__('Generate Barcodes'). '".'; ?>
</div>
</fieldset>
<?php

// create table object
$table = new simbio_table();
$table->table_attr = 'align="center" class="border fullWidth" cellpadding="5" cellspacing="0"';

// initial row count
$row = 1;
$row_num = 6;

// submit button
$table->appendTableRow(array(__('Barcode Size').' : <select name="size"><option value="1">'.__('Small').'</option>
    <option value="2" selected>'.__('Medium').'</option>
    <option value="3">'.__('Big').'</option></select>'));
// set cell attribute
$table->setCellAttr($row, 0, 'colspan="3" class="alterCell"');
$row++;

// barcode text fields
while ($row <= $row_num) {
    $table->appendTableRow(array('<input type="text" name="barcode[]" style="width: 100%;" />',
        '<input type="text" name="barcode[]" style="width: 100%;" />',
        '<input type="text" name="barcode[]" style="width: 100%;" />'));
    $row++;
}

// submit button
$table->appendTableRow(array('<input type="submit" name="saveData" value="'.__('Generate Barcodes').'" />'));
// set cell attribute
$table->setCellAttr($row_num+1, 0, 'colspan="3" class="alterCell"');

echo '<form name="barcodeForm" id="barcodeForm" target="submitExec" method="post" action="'.$_SERVER['PHP_SELF'].'">';
echo $table->printTable();
echo '</form>';
// for debugging purpose only
// echo '<iframe name="submitExec" id="submitExec" style="width: 100%; height: 200px; visibility: visible;"></iframe>';
echo '<iframe name="submitExec" id="submitExec" style="width: 0; height: 0; visibility: hidden;"></iframe>';
?>
