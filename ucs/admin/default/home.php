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

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    include_once '../../ucsysconfig.inc.php';
}

// generate warning messages
$warnings = array();
// check GD extension
if (!extension_loaded('gd')) {
    $warnings[] = __('<strong>PHP GD</strong> extension is not installed. Please install it or application won\'t be able to create image thumbnail.');
}
// check mysqldump
if (!file_exists($sysconf['mysqldump'])) {
    $warnings[] = __('The PATH for <strong>mysqldump</strong> program is not right! Please check configuration file or you won\'t be able to do any database backups.');
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
