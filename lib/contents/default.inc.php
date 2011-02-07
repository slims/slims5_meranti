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

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

/* Showing list of catalogues and also for searching handling */

// include required class class
require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_tokenizecql.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require LIB_DIR.'biblio_list_model.inc.php';
// index choice
if ($sysconf['index']['type'] == 'index') {
    require LIB_DIR.'biblio_list_index.inc.php';
} else if ($sysconf['index']['type'] == 'sphinx' && file_exists(LIB_DIR.'sphinx/sphinxapi.php')) {
    require LIB_DIR.'sphinx/sphinxapi.php';
    require LIB_DIR.'biblio_list_sphinx.inc.php';
    $sysconf['opac_result_num'] = (int)$sysconf['opac_result_num'];
} else {
    require LIB_DIR.'biblio_list.inc.php';
}

// create biblio list object
try {
    $biblio_list = new biblio_list($dbs, $sysconf['opac_result_num']);
} catch (Exception $err) {
    die($err->getMessage());
}

if (isset($sysconf['enable_xml_detail']) && !$sysconf['enable_xml_detail']) {
    $biblio_list->xml_detail = false;
}

// if we are in searching mode
if (isset($_GET['search']) && !empty($_GET['search'])) {
    // default vars
    $is_adv = false;
    $keywords = '';
    $criteria = '';
    // simple search
    if (isset($_GET['keywords'])) {
        $keywords = trim(strip_tags(urldecode($_GET['keywords'])));
    }
    if ($keywords && !preg_match('@[a-z0-9_.]+=[^=]+\s+@i', $keywords.' ')) {
        $criteria = 'title='.$keywords.' OR author='.$keywords.' OR subject='.$keywords.' OR notes='.$keywords;
        $biblio_list->setSQLcriteria($criteria);
    } else {
        $biblio_list->setSQLcriteria($keywords);
    }
    // advanced search
    $is_adv = isset($_GET['search']) || isset($_GET['title']) || isset($_GET['author']) || isset($_GET['isbn'])
        || isset($_GET['subject']) || isset($_GET['location'])
        || isset($_GET['gmd']) || isset($_GET['colltype']) || isset($_GET['publisher']) || isset($_GET['callnumber']);
    if ($is_adv) {
        $title = '';
        if (isset($_GET['title'])) {
            $title = trim(strip_tags(urldecode($_GET['title'])));
        }
        $author = '';
        if (isset($_GET['author'])) {
            $author = trim(strip_tags(urldecode($_GET['author'])));
        }
        $subject = '';
        if (isset($_GET['subject'])) {
            $subject = trim(strip_tags(urldecode($_GET['subject'])));
        }
        $isbn = '';
        if (isset($_GET['isbn'])) {
            $isbn = trim(strip_tags(urldecode($_GET['isbn'])));
        }
        $gmd = '';
        if (isset($_GET['gmd'])) {
            $gmd = trim(strip_tags(urldecode($_GET['gmd'])));
        }
        $colltype = '';
        if (isset($_GET['colltype'])) {
            $colltype = trim(strip_tags(urldecode($_GET['colltype'])));
        }
        $location = '';
        if (isset($_GET['location'])) {
            $location = trim(strip_tags(urldecode($_GET['location'])));
        }
        $publisher = '';
        if (isset($_GET['publisher'])) {
            $publisher = trim(strip_tags(urldecode($_GET['publisher'])));
        }
        $callnumber = '';
        if (isset($_GET['callnumber'])) {
            $callnumber = trim(strip_tags(urldecode($_GET['callnumber'])));
        }
        // don't do search if all search field is empty
        if ($title || $author || $subject || $isbn || $gmd || $colltype || $location || $publisher || $callnumber) {
            $criteria = '';
            if ($title) { $criteria .= ' title='.$title; }
            if ($author) { $criteria .= ' author='.$author; }
            if ($subject) { $criteria .= ' subject='.$subject; }
            if ($isbn) { $criteria .= ' isbn='.$isbn; }
            if ($gmd) { $criteria .= ' gmd="'.$gmd.'"'; }
            if ($colltype) { $criteria .= ' colltype="'.$colltype.'"'; }
            if ($location) { $criteria .= ' location="'.$location.'"'; }
            if ($publisher) { $criteria .= ' publisher="'.$publisher.'"'; }
            if ($callnumber) { $criteria .= ' callnumber="'.$callnumber.'"'; }
            $criteria = trim($criteria);
            $biblio_list->setSQLcriteria($criteria);
        }
    }

    // search result info construction
    if ($is_adv) {
        $info .= '<div style="clear: both;">'.__('Found  <strong>{biblio_list->num_rows}</strong> from your keywords').': <strong><cite>'.$keywords.'</cite></strong></div>  '; //mfc
        if ($title) { $info .= 'Title : <strong><cite>'.$title.'</cite></strong>, '; }
        if ($author) { $info .= 'Author : <strong><cite>'.$author.'</cite></strong>, '; }
        if ($subject) { $info .= 'Subject : <strong><cite>'.$subject.'</cite></strong>, '; }
        if ($isbn) { $info .= 'ISBN/ISSN : <strong><cite>'.$isbn.'</cite></strong>, '; }
        if ($gmd) { $info .= 'GMD : <strong><cite>'.$gmd.'</cite></strong>, '; }
        if ($colltype) { $info .= 'Collection Type : <strong><cite>'.$colltype.'</cite></strong>, '; }
        if ($location) { $info .= 'Location : <strong><cite>'.$location.'</cite></strong>, '; }
        if ($publisher) { $info .= 'Publisher : <strong><cite>'.$publisher.'</cite></strong>, '; }
        if ($callnumber) { $info .= 'Call Number : <strong><cite>'.$callnumber.'</cite></strong>, '; }
        // strip last comma
        $info = substr_replace($info, '', -2);
    } else {
        $info .= '<div style="clear: both;">'.__('Found  <strong>{biblio_list->num_rows}</strong> from your keywords').': <strong><cite>'.$keywords.'</cite></strong></div>'; //mfc
    }
} else {
    // show promoted titles
    if (isset($sysconf['enable_promote_titles']) && $sysconf['enable_promote_titles']) {
        $biblio_list->only_promoted = true;
    }
}

// check if we are on xml resultset mode
if (isset($_GET['resultXML']) && $sysconf['enable_xml_result']) {
    // get document list but don't output the result
    $biblio_list->getDocumentList(false);
    if ($biblio_list->num_rows > 0) {
        // send http header
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo $biblio_list->XMLresult();
    }
    exit();
} else {
    // show the list
    echo $biblio_list->getDocumentList();
    echo '<br />'."\n";
    // set result number info
    $info = str_replace('{biblio_list->num_rows}', $biblio_list->num_rows, $info);
}
// count total pages
$total_pages = ceil($biblio_list->num_rows/$sysconf['opac_result_num']);

// page number info
if (isset($_GET['page']) AND $_GET['page'] > 1) {
    $page = intval($_GET['page']);
    $msg = str_replace('{page}', $page, __('You currently on page <strong>{page}</strong> of <strong>{total_pages}</strong> page(s)')); //mfc
    $msg = str_replace('{total_pages}', $total_pages, $msg);
    $info .= '<div style="clear: both;">'.$msg.'</div>';
} else {
    $page = 1;
}
// query time
$info .= '<div>'.__('Query took').' <b>'.$biblio_list->query_time.'</b> '.__('second(s) to complete').'</div>'; //mfc
if (isset($biblio_list) && isset($sysconf['enable_xml_result']) && $sysconf['enable_xml_result']) {
    $info .= '<div><a href="index.php?resultXML=true&'.$_SERVER['QUERY_STRING'].'" class="xmlResultLink" target="_blank" title="View Result in XML Format" style="clear: both;">XML Result</a></div>';
}
?>
