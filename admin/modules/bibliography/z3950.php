<?php
/**
 * Copyright (C) 2009 Arie Nugraha (dicarve@yahoo.com)
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

/* Z3950 Web Services section */

// start the session
require '../../../sysconfig.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'._('You are not authorized to view this section').'</div>');
}

if (!extension_loaded('yaz')) {
    die('<div class="errorBox">YAZ extension library is not loaded/installed yet. '
        .'YAZ library is needed to use z3950 enabled service. '
        .'Please refer to official <a href="http://www.php.net/manual/en/book.yaz.php" target="_blank">YAZ PHP Manual</a>'
        .' on how to setup/install YAZ extension library in PHP.</div>');
}

$zserver[] = 'z3950.loc.gov:7090/voyager';

/* RECORD OPERATION */
if (isset($_POST['saveZ']) AND isset($_SESSION['z3950result'])) {
    /**
     * Utility function to get author ID
     **/
    function getAuthorID($str_author_name, $str_author_type, &$arr_cache = false)
    {
        global $dbs;
        $str_value = trim($str_author_name);
        if ($arr_cache) {
            if (isset($arr_cache[$str_value])) {
                return $arr_cache[$str_value];
            }
        }

        $str_value = $dbs->escape_string($str_value);
        $id_q = $dbs->query('SELECT author_id FROM mst_author WHERE author_name=\''.$str_value.'\'');
        if ($id_q->num_rows > 0) {
            $id_d = $id_q->fetch_row();
            unset($id_q);
            // cache
            if ($arr_cache) { $arr_cache[$str_value] = $id_d[0]; }
            return $id_d[0];
        } else {
            $_curr_date = date('Y-m-d');
            // if not found then we insert it as new value
            $dbs->query('INSERT IGNORE INTO mst_author (author_name, authority_type, input_date, last_update)'
                .' VALUES (\''.$str_value.'\', \''.$str_author_type.'\', \''.$_curr_date.'\', \''.$_curr_date.'\')');
            if (!$dbs->error) {
                // cache
                if ($arr_cache) { $arr_cache[$str_value] = $dbs->insert_id; }
                return $dbs->insert_id;
            }
        }
    }


    /**
     * Utility function to get subject ID
     **/
    function getSubjectID($str_subject, $str_subject_type, &$arr_cache = false)
    {
        global $dbs;
        $str_value = trim($str_subject);
        if ($arr_cache) {
            if (isset($arr_cache[$str_value])) {
                return $arr_cache[$str_value];
            }
        }

        $str_value = $dbs->escape_string($str_value);
        $id_q = $dbs->query('SELECT topic_id FROM mst_topic WHERE topic=\''.$str_value.'\'');
        if ($id_q->num_rows > 0) {
            $id_d = $id_q->fetch_row();
            unset($id_q);
            // cache
            if ($arr_cache) { $arr_cache[$str_value] = $id_d[0]; }
            return $id_d[0];
        } else {
            $_curr_date = date('Y-m-d');
            // if not found then we insert it as new value
            $dbs->query('INSERT IGNORE INTO mst_topic (topic, topic_type, input_date, last_update)'
                .' VALUES (\''.$str_value.'\', \''.$str_subject_type.'\', \''.$_curr_date.'\', \''.$_curr_date.'\')');
            if (!$dbs->error) {
                // cache
                if ($arr_cache) { $arr_cache[$str_value] = $dbs->insert_id; }
                return $dbs->insert_id;
            } else {
                echo $dbs->error;
            }
        }
    }


    $gmd_cache = array();
    $publ_cache = array();
    $place_cache = array();
    $lang_cache = array();
    $author_cache = array();
    $subject_cache = array();
    $input_date = date('Y-m-d H:i:s');
    // create dbop object
    $sql_op = new simbio_dbop($dbs);
    $r = 0;
    foreach ($_POST['zrecord'] as $rec_idx) {
        // get the record from session
        $biblio = $_SESSION['z3950result'][$rec_idx];
        // escape all string value
        foreach ($biblio as $field => $content) { if (is_string($content)) { $biblio[$field] = $dbs->escape_string($content); } }
        // gmd
        $biblio['gmd_id'] = utility::getID($dbs, 'mst_gmd', 'gmd_id', 'gmd_name', $biblio['gmd'], $gmd_cache);
        unset($biblio['gmd']);
        // publisher
        $biblio['publisher_id'] = utility::getID($dbs, 'mst_publisher', 'publisher_id', 'publisher_name', $biblio['publisher'], $publ_cache);
        unset($biblio['publisher']);
        // publish place
        $biblio['publish_place_id'] = utility::getID($dbs, 'mst_place', 'place_id', 'place_name', $biblio['publish_place'], $place_cache);
        unset($biblio['publish_place']);
        // language
        $biblio['language_id'] = utility::getID($dbs, 'mst_language', 'language_id', 'language_name', $biblio['language'], $lang_cache);
        unset($biblio['language']);
        // author primary
        $author_main = $biblio['author_main'];
        unset($biblio['author_main']);
        // authors additional
        $authors_add = $biblio['authors_add'];
        unset($biblio['authors_add']);
        // authors corporate body
        $authors_corp = $biblio['authors_corp'];
        unset($biblio['authors_corp']);
        // authors conference
        $authors_conf = $biblio['authors_conf'];
        unset($biblio['authors_conf']);
        // subject
        $subjects = $biblio['subjects'];
        unset($biblio['subjects']);
        // unset copies
        unset($biblio['copies']);
        $biblio['input_date'] = $input_date;
        $biblio['last_update'] = $input_date;
        // title
        $biblio['title'] = trim(substr_replace($biblio['title'], '', strpos($biblio['title'], '/')));

        // fot debugging purpose
        // var_dump($biblio);
        // die();

        // insert biblio data
        $sql_op->insert('biblio', $biblio);
        echo '<p>'.$sql_op->error.'</p><p>&nbsp;</p>';
        $biblio_id = $sql_op->insert_id;
        if ($biblio_id < 1) {
            continue;
        }
        // insert author
        if ($author_main) {
            // author
            $author_id = utility::getID($dbs, 'mst_author', 'author_id', 'author_name', $author_main, $author_cache);
            @$dbs->query("INSERT IGNORE INTO biblio_author (biblio_id, author_id, level) VALUES ($biblio_id, $author_id, 1)");
        }
        // insert additional personal name authors
        if ($authors_add) {
            $author_id = 0;
            $author_type = 'p';
            foreach ($authors_add as $add_author) {
                $author_id = getAuthorID($add_author, $author_type, $author_cache);
                @$dbs->query("INSERT IGNORE INTO biblio_author (biblio_id, author_id, level) VALUES ($biblio_id, $author_id, 1)");
            }
        }
        // insert corporate body authors
        if ($authors_corp) {
            $author_id = 0;
            $author_type = 'o';
            foreach ($authors_corp as $author_corp) {
                $author_id = getAuthorID($author_corp, $author_type, $author_cache);
                @$dbs->query("INSERT IGNORE INTO biblio_author (biblio_id, author_id, level) VALUES ($biblio_id, $author_id, 1)");
            }
        }
        // insert conference/meeting authors
        if ($authors_conf) {
            $author_id = 0;
            $author_type = 'c';
            foreach ($authors_conf as $author_conf) {
                $author_id = getAuthorID($author_conf, $author_type, $author_cache);
                @$dbs->query("INSERT IGNORE INTO biblio_author (biblio_id, author_id, level) VALUES ($biblio_id, $author_id, 1)");
            }
        }
        // insert subject/topical terms
        if ($subjects) {
            foreach ($subjects as $subject) {
                $subject_type = 't';
                $subject_id = getSubjectID($subject, $subject_type, $subject_cache);
                @$dbs->query("INSERT IGNORE INTO biblio_topic (biblio_id, topic_id, level) VALUES ($biblio_id, $subject_id, 1)");
            }
        }
        if ($biblio_id) { $r++; }
    }
    // destroy result Z3950 session
    unset($_SESSION['z3950result']);
    utility::jsAlert($r.' records inserted to database.');
    echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'get\');</script>';
    exit();
}
/* RECORD OPERATION END */

/* SEARCH OPERATION */
if (isset($_GET['keywords']) AND $can_read) {
    require LIB_DIR.'marcxmlsenayan.inc.php';
    $_SESSION['z3950result'] = array();
    $keywords = trim($_GET['keywords']);
    $num_hosts = count($zserver);
    $query = '';
    if ($keywords) {
        // parsing keywords and map query to RPN
        switch ($_GET['field']) {
            case 'ti' :
                $query = '@or @and @attr 1=4 '.$keywords.' @and @attr 1=5 '.$keywords;
            break;
            case 'au' :
                $query = '@attr 1=1 @and '.$keywords;
            break;
            default :
                $query = '@or @attr 1=7 '.$keywords.' @attr 1=8 '.$keywords;
            break;
        }

        for ($h = 0; $h < $num_hosts; $h++) {
            $id[] = yaz_connect($zserver[$h]);
            yaz_syntax($id[$h], 'usmarc');
            yaz_range($id[$h], 1, 20);
            yaz_search($id[$h], 'rpn', $query);
        }
        yaz_wait();
        // preparing to buffer MARC XML result
        $errors = array();
        $hits = 0;
        ob_start();
        echo '<?xml version="1.0" standalone="yes"?>'."\n";
        echo '<collection xmlns="http://www.loc.gov/MARC21/slim">'."\n";
        for ($h = 0; $h < $num_hosts; $h++) {
            $error = yaz_error($id[$h]);
            if (!empty($error)) {
                $errors[] = $error;
            } else {
                // number of results
                $hits = yaz_hits($id[$h]);
            }
            for ($rnum = 1; $rnum <= 20; $rnum++) {
                $rec = yaz_record($id[$h], $rnum, 'xml; charset=marc-8,utf-8');
                if (empty($rec)) continue;
                echo $rec;
            }
        }
        echo '</collection>';
        $xml_result_string = ob_get_clean();
        // below is for debugging purpose
        // echo htmlentities($xml_result_string);

        if ($hits > 0) {
            echo '<div class="infoBox">Found '.$hits.' records from Z3950 Server, only 20 listed.</div>';
            // parse XML
            $xmlrec = marcXMLsenayan($xml_result_string);
            // save it to session vars for retrieving later
            $_SESSION['z3950result'] = $xmlrec;
            // create list and form
            echo '<form method="post" action="'.MODULES_WEB_ROOT_DIR.'bibliography/z3950.php" target="blindSubmit">';
            echo '<table align="center" id="dataList" cellpadding="5" cellspacing="0">';
            echo '<tr>';
            echo '<td colspan="3"><input type="submit" name="saveZ" value="Save Z3950 Records to Database" /></td>';
            echo '</tr>';
            // loop records
            $row = 1;
            foreach ($xmlrec as $rec_idx => $rec) {
                $row_class = ($row%2 == 0)?'alterCell':'alterCell2';
                echo '<tr>';
                echo '<td width="1%" class="'.$row_class.'"><input type="checkbox" name="zrecord['.$rec_idx.']" value="'.$rec_idx.'" /></td>';
                echo '<td width="80%" class="'.$row_class.'"><strong>'.$rec['title'].'</strong><div><i>'.$rec['author_main'].'</i></div></td>';
                echo '<td width="19%" class="'.$row_class.'">'.$rec['isbn_issn'].'</td>';
                echo '</tr>';
                $row++;
            }
            echo '</table>';
            echo '</form>';
        } else if ($errors) {
            echo '<div class="errorBox"><ul>';
            foreach ($errors as $errmsg) {
                echo '<li>'.$errmsg.'</li>';
            }
            echo '</ul></div>';
        } else {
            echo '<div class="errorBox">No Results Found!</div>';
        }
    } else {
        echo '<div class="errorBox">No Keywords Supplied!</div>';
    }
    exit();
}
/* SEARCH OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner biblioIcon">
    Z3950
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo _('Search'); ?> :
    <input type="text" name="keywords" id="keywords" size="30" />
    <select name="field"><option value="isbn"><?php echo _('ISBN/ISSN'); ?></option><option value="ti"><?php echo _('Title/Series Title'); ?></option><option value="au"><?php echo _('Authors'); ?></option></select>
    <input type="button" id="doSearch" onclick="setContent('searchResult', '<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/z3950.php?' + $('search').serialize(), 'get')" value="<?php echo _('Search'); ?>" class="button" />
    </form>
    <div><?php echo _('* Please make sure you have a working Internet connection.'); ?></div>
</div>
</fieldset>
<script type="text/javascript">
// focus keywords text field
$('keywords').focus();
</script>
<div id="searchResult">&nbsp;</div>
