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

/* Stock Take Upload */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';

// privileges checking
$can_read = utility::havePrivilege('stock_take', 'r');
$can_write = utility::havePrivilege('stock_take', 'w');

if (!($can_read AND $can_write)) {
    die('<div class="errorBox">'._('You don\'t have enough privileges to access this area!').'</div>');
}

// check if there is any active stock take proccess
$stk_query = $dbs->query('SELECT * FROM stock_take WHERE is_active=1');
if ($stk_query->num_rows < 1) {
    echo '<div class="errorBox">'._('NO stock taking proccess initialized yet!').'</div>';
    die();
}

// file upload
if (isset($_POST['stUpload']) && isset($_FILES['stFile'])) {
    require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';
    // create upload object
    $upload = new simbio_file_upload();
    $upload->setAllowableFormat(array('.txt'));
    $upload->setMaxSize($sysconf['max_upload']*1024);
    $upload->setUploadDir(FILES_UPLOAD_DIR);
    // upload the file and change all space characters to underscore
    $upload_status = $upload->doUpload('stFile');
    if ($upload_status == UPLOAD_SUCCESS) {
        // write log
        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'stock_take', $_SESSION['realname'].' upload stock take file '.$upload->new_filename);
        // open file
        $stfile = @fopen(FILES_UPLOAD_DIR.$upload->new_filename, 'r');
        if (!$stfile) {
            echo '<script type="text/javascript">'."\n";
            echo 'parent.$(\'stUploadMsg\').update(\'Failed to open stock take file '.$upload->new_filename.'. Please check permission for directory '.FILES_UPLOAD_DIR.'\');'."\n";
            echo 'parent.$(\'stUploadMsg\').className = \'errorBox\';'."\n";
            echo 'parent.$(\'stUploadMsg\').setStyle( {display: \'block\'} );'."\n";
            echo '</script>';
            exit();
        }
        // start loop
        $i = 0;
        while (!feof($stfile)) {
            $curr_time = date('Y-m-d H:i:s');
            $item_code = fgetss($stfile, 512);
            $item_code = trim($item_code);
            if (!$item_code) {
                continue;
            }
            $update = @$dbs->query("UPDATE LOW_PRIORITY stock_take_item SET status='e', checked_by='".$_SESSION['realname']."', last_update='".$curr_time."' WHERE item_code='$item_code'");
            $update = @$dbs->query("UPDATE LOW_PRIORITY stock_take SET total_item_lost=total_item_lost-1 WHERE is_active=1");
            $i++;
        }
        fclose($stfile);
        // message
        echo '<script type="text/javascript">'."\n";
        echo 'parent.$(\'stUploadMsg\').update(\''._('Succesfully upload stock take file').$upload->new_filename.', <b>'.$i.'</b>'._(' item codes scanned!').'\');'."\n"; //mfc
        echo 'parent.$(\'stUploadMsg\').setStyle( {display: \'block\'} );'."\n";
        echo '</script>';
    } else {
        // write log
        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'stock_take', 'ERROR : '.$_SESSION['realname'].' FAILED TO upload stock take file '.$upload->new_filename.', with error ('.$upload->error.')');
        echo '<script type="text/javascript">'."\n";
        echo 'parent.$(\'stUploadMsg\').update(\'Failed to upload stock take file! <div>Error : '.$upload->error.'</div>\');'."\n";
        echo 'parent.$(\'stUploadMsg\').className = \'errorBox\';'."\n";
        echo 'parent.$(\'stUploadMsg\').setStyle( {display: \'block\'} );'."\n";
        echo '</script>';
    }
    exit();
}

?>
<fieldset class="menuBox">
<div class="menuBoxInner stockTakeIcon">
    <?php echo _('STOCK TAKE UPLOAD - Upload a plain text file (.txt) containing list of Item Code to stock take. Each Item Code separated by line.'); ?><hr />
    <form name="uploadForm" method="post" enctype="multipart/form-data" action="<?php echo MODULES_WEB_ROOT_DIR.'stock_take/st_upload.php'; ?>" target="uploadAction" style="display: inline;">
    <?php echo _(' File'); //mfc ?>: <input type="file" name="stFile" id="stFile" /> Maximum <?php echo $sysconf['max_upload']; ?> KB
    <div style="margin: 3px;"><input type="submit" name="stUpload" id="stUpload" value="<?php echo _('Upload File'); ?>" class="button" />
    <iframe name="uploadAction" style="width: 0; height: 0; visibility: hidden;"></iframe>
    </div>
    </form>
</div>
</fieldset>
<div id="stUploadMsg" class="infoBox" style="display: none;">&nbsp;</div>&nbsp;
