<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) { 
    die("can not access this file directly");
}

/* Showing record detail in HTML and XML */

if (isset($_GET['inXML']) AND !empty($_GET['inXML'])) {
    if (!$sysconf['enable_xml_detail']) {
        die('XML Detail is disabled');
    }
    // filter the ID
    $detail_id = intval($_GET['id']);
    // include detail library and template
    include LIB_DIR.'detail.inc.php';
    // create detail object
    $detail = new detail($dbs, $detail_id, 'mods');
    $output = $detail->showDetail();
    // send http header
    header('Content-Type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
    echo $detail->getPrefix();
    echo $output;
    echo $detail->getSuffix();
    exit();
} else {
    // filter the ID
    $detail_id = intval($_GET['id']);
    // include detail library and template
    include LIB_DIR.'detail.inc.php';
    include $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/detail_template.php';
    // create detail object
    $detail = new detail($dbs, $detail_id);
    $detail->setListTemplate($detail_template);
    // set the content for info box
    $info = '<strong>'.strtoupper(__('Record Detail')).'</strong><hr />';
    if (!defined('LIGHTWEIGHT_MODE')) {
        $info .= '<a href="javascript: history.back();">'.__('Back To Previous').'</a> &nbsp;';
    }
    if (isset($sysconf['enable_xml_detail']) && $sysconf['enable_xml_detail'] && !defined('LIGHTWEIGHT_MODE')) {
        $info .= '<a href="index.php?p=show_detail&inXML=true&id='.$detail_id.'" class="xmlDetailLink" target="_blank">XML Detail</a>';
    }
    // output the record detail
    echo $detail->showDetail();
    $page_title = $detail->record_title;
    $metadata = $detail->metadata;
    echo '<br />'."\n";
}
?>
