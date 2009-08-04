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

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    include_once '../../sysconfig.inc.php';
}

// generate warning messages
$warnings = array();
// check GD extension
if (!extension_loaded('gd')) {
    $warnings[] = lang_sys_common_gd_not_loaded;
} else {
    // check GD Freetype
    if (!function_exists('imagettftext')) {
        $warnings[] = lang_sys_common_gd_freetype_not_loaded;
    }
}
// check for overdue
$overdue_q = $dbs->query('SELECT COUNT(loan_id) FROM loan AS l WHERE (l.is_lent=1 AND l.is_return=0 AND TO_DAYS(due_date) < TO_DAYS(\''.date('Y-m-d').'\')) GROUP BY member_id');
$num_overdue = $overdue_q->num_rows;
if ($num_overdue > 0) {
    $warnings[] = str_replace('{num_overdue}', $num_overdue, lang_sys_common_overdue);
    $overdue_q->free_result();
}
// check if images dir is writable or not
if (!is_writable(IMAGES_BASE_DIR) OR !is_writable(IMAGES_BASE_DIR.'barcodes') OR !is_writable(IMAGES_BASE_DIR.'persons') OR !is_writable(IMAGES_BASE_DIR.'docs')) {
    $warnings[] = lang_sys_common_imagedir_unwritable;
}
// check if file repository dir is writable or not
if (!is_writable(REPO_BASE_DIR)) {
    $warnings[] = lang_sys_common_repodir_unwritable;
}
// check if file upload dir is writable or not
if (!is_writable(FILES_UPLOAD_DIR)) {
    $warnings[] = lang_sys_common_uploaddir_unwritable;
}
// check mysqldump
if (!file_exists($sysconf['mysqldump'])) {
    $warnings[] = lang_sys_common_mysqldump_not_found;
}

// if there any warnings
if ($warnings) {
    echo '<div style="padding: 3px; border: 1px dotted #FF0000; background: #FFFFFF;">';
    echo '<ul>';
    foreach ($warnings as $warning_msg) {
        echo '<li style="color: #FF0000;">'.$warning_msg.'</li>';
    }
    echo '</ul>';
    echo '</div>';
}

// admin page content
require LIB_DIR.'content.inc.php';
$content = new content();
$content_data = $content->get($dbs, 'adminhome');
if ($content_data) {
    echo '<div class="contentDesc">'.$content_data['Content'].'</div>';
    unset($content_data);
}
?>
