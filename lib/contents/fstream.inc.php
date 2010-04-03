<?php
/**
 * Copyright (C) 2007,2008, 2009  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

/* File Viewer */

// get file ID
$fileID = isset($_GET['fid'])?(integer)$_GET['fid']:0;
// get biblioID
$biblioID = isset($_GET['bid'])?(integer)$_GET['bid']:0;

// query file to database
$sql_q = 'SELECT att.*, f.* FROM biblio_attachment AS att
    LEFT JOIN files AS f ON att.file_id=f.file_id
    WHERE att.file_id='.$fileID.' AND att.biblio_id='.$biblioID.' AND att.access_type=\'public\'';
$file_q = $dbs->query($sql_q);
$file_d = $file_q->fetch_assoc();

if ($file_q->num_rows > 0) {
    $file_loc = REPO_BASE_DIR.str_ireplace('/', DIRECTORY_SEPARATOR, $file_d['file_dir']).$file_d['file_name'];
    if (file_exists($file_loc)) {
        // check access limit
        if ($file_d['access_limit']) {
            if (utility::isMemberLogin()) {
                $allowed_mem_types = @unserialize($file_d['access_limit']);
                if (!in_array($_SESSION['m_member_type_id'], $allowed_mem_types)) {
                    # Access to file restricted
                    # Member logged in but doesnt have privilege to download
                    header("location:index.php");
                    exit();
                }
            } else {
                header("location:index.php");
                exit();
            }
        }

        if ($file_d['mime_type'] == 'application/pdf') {
            $swf = basename($file_loc);
            $swf = sha1($swf);
            $swf = $swf.'.swf';
            if (!file_exists('files/swfs/'.$swf.'')) {
                if (stripos(PHP_OS, 'Darwin') !== false) {
                    exec('lib/swftools/bin/darwin/pdf2swf -o files/swfs/'.$swf.' "'.$file_loc.'"');
                } else if (stripos(PHP_OS, 'Linux') !== false) {
                    exec('lib/swftools/bin/linux/pdf2swf -o files/swfs/'.$swf.' "'.$file_loc.'"');
                } else {
                    exec('lib\swftools\bin\windows\pdf2swf.exe -o files/swfs/'.$swf.' "'.$file_loc.'"');
                }
            }
            header('Location: js/zviewer/index.php?swf='.$swf.'&fid='.$fileID.'&bid='.$biblioID);
            exit();

        } else if (preg_match('@(image)/.+@i', $file_d['mime_type'])) {
            if ($sysconf['watermark']['enable']) {
                $imgurl = 'lib/phpthumb/phpThumb.php?src=../../repository/'.$file_d['file_dir'].'/'.basename($file_loc);
                if ($sysconf['watermark']['type'] == 'text') {
                    $imgurl .= '&fltr[]=wmt|';
                    $imgurl .= $sysconf['watermark']['text'].'|';
                    $imgurl .= $sysconf['watermark']['sizeoftext'].'|';
                    $imgurl .= $sysconf['watermark']['alignment'].'|';
                    $imgurl .= $sysconf['watermark']['color'].'||';
                    $imgurl .= $sysconf['watermark']['opacity'];
                } elseif ($sysconf['watermark']['type'] == 'image') {
                    $imgurl .= '&fltr[]=wmi|';
                    $imgurl .= $sysconf['watermark']['image'].'|';
                    $imgurl .= $sysconf['watermark']['alignment'].'|';
                    $imgurl .= $sysconf['watermark']['opacity'];
                }
                echo '<html><head><title>'.$file_d['file_title'].'</title></head><body>';
                echo "<img src='".$imgurl."' />";
                echo '</body></html>';
                exit();
            } else {
                header('Content-Disposition: inline; filename="'.basename($file_loc).'"');
                header('Content-Type: '.$file_d['mime_type']);
                readfile($file_loc);
                exit();
            }

        } else {
            header('Content-Disposition: inline; filename="'.basename($file_loc).'"');
            header('Content-Type: '.$file_d['mime_type']);
            readfile($file_loc);
            exit();
        }
    } else {
        die('<div class="errorBox">File Not Found!</div>');
    }
} else {
    die('<div class="errorBox">File Not Found!</div>');
}
?>
