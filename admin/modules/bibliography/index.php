<?php
/**
 * Copyright (C) 2007,2008,2009,2010  Arie Nugraha (dicarve@yahoo.com)
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

/* Bibliography Management section */

// key to authenticate
define('INDEX_AUTH', '1');

if (!defined('SENAYAN_BASE_DIR')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
}

require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';
require MODULES_BASE_DIR.'system/biblio_indexer.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You are not authorized to view this section').'</div>');
}

$in_pop_up = false;
// check if we are inside pop-up window
if (isset($_GET['inPopUp'])) {
    $in_pop_up = true;
}

/* RECORD OPERATION */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    $title = trim(strip_tags($_POST['title']));
    // check form validity
    if (empty($title)) {
        utility::jsAlert(__('Title can not be empty'));
        exit();
    } else {
        // include custom fields file
        if (file_exists(MODULES_BASE_DIR.'bibliography/custom_fields.inc.php')) {
            include MODULES_BASE_DIR.'bibliography/custom_fields.inc.php';
        }

        // create biblio_indexer class instance
        $indexer = new biblio_indexer($dbs);

        /**
         * Custom fields
         */
        if (isset($biblio_custom_fields)) {
            if (is_array($biblio_custom_fields) && $biblio_custom_fields) {
                foreach ($biblio_custom_fields as $fid => $cfield) {
                    // custom field data
                    $cf_dbfield = $cfield['dbfield'];
                    if (isset($_POST[$cf_dbfield])) {
                        $cf_val = $dbs->escape_string(strip_tags(trim($_POST[$cf_dbfield]), $sysconf['content']['allowable_tags']));
                        if ($cf_val) {
                            $custom_data[$cf_dbfield] = $cf_val;
                        } else {
                            $custom_data[$cf_dbfield] = 'literal{\'\'}';
                        }
                    }
                }
            }
        }

        $data['title'] = $dbs->escape_string($title);
        $data['edition'] = trim($dbs->escape_string(strip_tags($_POST['edition'])));
        $data['gmd_id'] = $_POST['gmdID'];
        $data['isbn_issn'] = trim($dbs->escape_string(strip_tags($_POST['isbn_issn'])));
        $data['classification'] = trim($dbs->escape_string(strip_tags($_POST['class'])));
        // check publisher
        if ($_POST['publisherID'] != '0') {
            $data['publisher_id'] = intval($_POST['publisherID']);
        } else {
            if (!empty($_POST['publ_search_str'])) {
                $new_publisher = trim(strip_tags($_POST['publ_search_str']));
                $new_id = utility::getID($dbs, 'mst_publisher', 'publisher_id', 'publisher_name', $new_publisher);
                if ($new_id) {
                    $data['publisher_id'] = $new_id;
                } else {
                    $data['publisher_id'] = 'literal{NULL}';
                }
            } else {
                $data['publisher_id'] = 'literal{NULL}';
            }
        }
        $data['publish_year'] = trim($dbs->escape_string(strip_tags($_POST['year'])));
        $data['collation'] = trim($dbs->escape_string(strip_tags($_POST['collation'])));
        $data['series_title'] = trim($dbs->escape_string(strip_tags($_POST['seriesTitle'])));
        $data['call_number'] = trim($dbs->escape_string(strip_tags($_POST['callNumber'])));
        $data['language_id'] = trim($dbs->escape_string(strip_tags($_POST['languageID'])));
        // check place
        if ($_POST['placeID'] != '0') {
            $data['publish_place_id'] = intval($_POST['placeID']);
        } else {
            if (!empty($_POST['plc_search_str'])) {
                $new_place = trim(strip_tags($_POST['plc_search_str']));
                $new_id = utility::getID($dbs, 'mst_place', 'place_id', 'place_name', $new_place);
                if ($new_id) {
                    $data['publish_place_id'] = $new_id;
                } else {
                    $data['publish_place_id'] = 'literal{NULL}';
                }
            } else {
                $data['publish_place_id'] = 'literal{NULL}';
            }
        }
        $data['notes'] = trim($dbs->escape_string(strip_tags($_POST['notes'], '<br><p><div><span><i><em><strong><b><code>s')));
        $data['opac_hide'] = ($_POST['opacHide'] == '0')?'literal{0}':'1';
        $data['promoted'] = ($_POST['promote'] == '0')?'literal{0}':'1';
        // labels
        $arr_label = array();
        foreach ($_POST['labels'] as $label) {
            if (trim($label) != '') {
                $arr_label[] = array($label, isset($_POST['label_urls'][$label])?$_POST['label_urls'][$label]:null );
            }
        }
        $data['labels'] = $arr_label?serialize($arr_label):'literal{NULL}';
        $data['frequency_id'] = ($_POST['frequencyID'] == '0')?'literal{0}':(integer)$_POST['frequencyID'];
        $data['spec_detail_info'] = trim($dbs->escape_string(strip_tags($_POST['specDetailInfo'])));
        $data['input_date'] = date('Y-m-d H:i:s');
        $data['last_update'] = date('Y-m-d H:i:s');

        // image uploading
        if (!empty($_FILES['image']) AND $_FILES['image']['size']) {
            // create upload object
            $image_upload = new simbio_file_upload();
            $image_upload->setAllowableFormat($sysconf['allowed_images']);
            $image_upload->setMaxSize($sysconf['max_image_upload']*1024);
            $image_upload->setUploadDir(IMAGES_BASE_DIR.'docs');
            // upload the file and change all space characters to underscore
            $img_upload_status = $image_upload->doUpload('image', preg_replace('@\s+@i', '_', $_FILES['image']['name']));
            if ($img_upload_status == UPLOAD_SUCCESS) {
                $data['image'] = $dbs->escape_string($image_upload->new_filename);
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' upload image file '.$image_upload->new_filename);
                utility::jsAlert(__('Image Uploaded Successfully'));
            } else {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', 'ERROR : '.$_SESSION['realname'].' FAILED TO upload image file '.$image_upload->new_filename.', with error ('.$image_upload->error.')');
                utility::jsAlert(__('Image Uploaded Successfully'));
            }
        }

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            // update data
            $update = $sql_op->update('biblio', $data, 'biblio_id='.$updateRecordID);
            // send an alert
            if ($update) {
                // update custom data
                if (isset($custom_data)) {
                    // check if custom data for this record exists
                    $_sql_check_custom_q = sprintf('SELECT biblio_id FROM biblio_custom WHERE biblio_id=%d', $updateRecordID);
                    $check_custom_q = $dbs->query($_sql_check_custom_q);
                    if ($check_custom_q->num_rows) {
                        $update2 = @$sql_op->update('biblio_custom', $custom_data, 'biblio_id='.$updateRecordID);
                    } else {
                        $custom_data['biblio_id'] = $updateRecordID;
                        @$sql_op->insert('biblio_custom', $custom_data);
                    }
                }
            	if ($sysconf['bibliography_update_notification']) {
                    utility::jsAlert(__('Bibliography Data Successfully Updated'));
			    }
                // auto insert catalog to UCS if enabled
                if ($sysconf['ucs']['enable']) {
                    echo '<script type="text/javascript">parent.ucsUpload(\''.MODULES_WEB_ROOT_DIR.'bibliography/ucs_upload.php\', \'itemID[]='.$updateRecordID.'\', false);</script>';
                }
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' update bibliographic data ('.$data['title'].') with biblio_id ('.$_POST['itemID'].')');
                // close window OR redirect main page
                if ($in_pop_up) {
                    $itemCollID = (integer)$_POST['itemCollID'];
                    echo '<script type="text/javascript">top.$(\'#mainContent\').simbioAJAX(parent.jQuery.ajaxHistory[0].url, {method: \'post\', addData: \''.( $itemCollID?'itemID='.$itemCollID.'&detail=true':'' ).'\'});</script>';
                    echo '<script type="text/javascript">top.closeHTMLpop();</script>';
                } else {
                    echo '<script type="text/javascript">top.$(\'#mainContent\').simbioAJAX(parent.jQuery.ajaxHistory[0].url);</script>';
                }
                // update index
                // delete from index first
                $sql_op->delete('search_biblio', "biblio_id=$updateRecordID");
                $indexer->makeIndex($updateRecordID);
            } else { utility::jsAlert(__('Bibliography Data FAILED to Updated. Please Contact System Administrator')."\n".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            $insert = $sql_op->insert('biblio', $data);
            if ($insert) {
                // get auto id of this record
                $last_biblio_id = $sql_op->insert_id;
                // add authors
                if ($_SESSION['biblioAuthor']) {
                    foreach ($_SESSION['biblioAuthor'] as $author) {
                        $sql_op->insert('biblio_author', array('biblio_id' => $last_biblio_id, 'author_id' => $author[0], 'level' => $author[1]));
                    }
                }
                // add topics
                if ($_SESSION['biblioTopic']) {
                    foreach ($_SESSION['biblioTopic'] as $topic) {
                        $sql_op->insert('biblio_topic', array('biblio_id' => $last_biblio_id, 'topic_id' => $topic[0], 'level' => $topic[1]));
                    }
                }
                // add attachment
                if ($_SESSION['biblioAttach']) {
                    foreach ($_SESSION['biblioAttach'] as $attachment) {
                        $sql_op->insert('biblio_attachment', array('biblio_id' => $last_biblio_id, 'file_id' => $attachment['file_id'], 'access_type' => $attachment['access_type']));
                    }
                }
                // insert custom data
                if ($custom_data) {
                    $custom_data['biblio_id'] = $last_biblio_id;
                    @$sql_op->insert('biblio_custom', $custom_data);
                }

                utility::jsAlert(__('New Bibliography Data Successfully Saved'));
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' insert bibliographic data ('.$data['title'].') with biblio_id ('.$last_biblio_id.')');
                // clear related sessions
                $_SESSION['biblioAuthor'] = array();
                $_SESSION['biblioTopic'] = array();
                $_SESSION['biblioAttach'] = array();
                // update index
                $indexer->makeIndex($last_biblio_id);
                // auto insert catalog to UCS if enabled
                if ($sysconf['ucs']['enable'] && $sysconf['ucs']['auto_insert']) {
                    echo '<script type="text/javascript">parent.ucsUpload(\''.MODULES_WEB_ROOT_DIR.'bibliography/ucs_upload.php\', \'itemID[]='.$last_biblio_id.'\');</script>';
                }
                echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.MODULES_WEB_ROOT_DIR.'bibliography/index.php\', {method: \'post\', addData: \'itemID='.$last_biblio_id.'&detail=true\'});</script>';
            } else { utility::jsAlert(__('Bibliography Data FAILED to Save. Please Contact System Administrator')."\n".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    // create sql op object
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    $still_have_item = array();
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array((integer)$_POST['itemID']);
    }
    // loop array
    $http_query = '';
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = (integer)$itemID;
        // check if this biblio data still have an item
        $_sql_biblio_item_q = sprintf('SELECT b.title, COUNT(item_id) FROM biblio AS b
            LEFT JOIN item AS i ON b.biblio_id=i.biblio_id
            WHERE b.biblio_id=%d GROUP BY title', $itemID);
        $biblio_item_q = $dbs->query($_sql_biblio_item_q);
        $biblio_item_d = $biblio_item_q->fetch_row();
        if ($biblio_item_d[1] < 1) {
            if (!$sql_op->delete('biblio', "biblio_id=$itemID")) {
                $error_num++;
            } else {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' DELETE bibliographic data ('.$biblio_item_d[0].') with biblio_id ('.$itemID.')');
                // delete related data
                $sql_op->delete('biblio_topic', "biblio_id=$itemID");
                $sql_op->delete('biblio_author', "biblio_id=$itemID");
                $sql_op->delete('biblio_attachment', "biblio_id=$itemID");
                $sql_op->delete('search_biblio', "biblio_id=$itemID");
                // add to http query for UCS delete
                $http_query .= "itemID[]=$itemID&";
            }
        } else {
            $still_have_item[] = substr($biblio_item_d[0], 0, 45).'... still have '.$biblio_item_d[1].' copies';
            $error_num++;
        }
    }

    if ($still_have_item) {
        $titles = '';
        foreach ($still_have_item as $title) {
            $titles .= $title."\n";
        }
        utility::jsAlert(__('Below data can not be deleted:')."\n".$titles);
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\', {addData: \''.$_POST['lastQueryStr'].'\'});</script>';
        exit();
    }
    // auto delete data on UCS if enabled
    if ($http_query && $sysconf['ucs']['enable'] && $sysconf['ucs']['auto_delete']) {
        echo '<script type="text/javascript">parent.ucsUpdate(\''.MODULES_WEB_ROOT_DIR.'bibliography/ucs_update.php\', \'nodeOperation=delete&'.$http_query.'\');</script>';
    }
    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(__('All Data Successfully Deleted'));
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\', {addData: \''.$_POST['lastQueryStr'].'\'});</script>';
    } else {
        utility::jsAlert(__('Some or All Data NOT deleted successfully!\nPlease contact system administrator'));
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\', {addData: \''.$_POST['lastQueryStr'].'\'});</script>';
    }
    exit();
}
/* RECORD OPERATION END */

if (!$in_pop_up) {
/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner biblioIcon">
    <?php echo strtoupper(__('Bibliographic')); ?> - <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/index.php?action=detail" class="headerText2"><?php echo __('Add New Bibliography'); ?></a>
    &nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/index.php" class="headerText2"><?php echo __('Bibliographic List'); ?></a>
    <?php
    // enable UCS?
    if ($sysconf['ucs']['enable']) {
    ?>
    <div class="marginTop"><a href="#" onclick="ucsUpload('<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/ucs_upload.php', serializeChbox('dataList'))" class="notAJAX ucsUpload"><?php echo __('Upload Selected Bibliographic data to Union Catalog Server*'); ?></a></div>
    <?php
    }
    ?>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/index.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" id="keywords" size="30" />
    <select name="field"><option value="0"><?php echo __('All Fields'); ?></option><option value="title"><?php echo __('Title/Series Title'); ?> </option><option value="subject"><?php echo __('Topics'); ?></option><option value="author"><?php echo __('Authors'); ?></option><option value="isbn"><?php echo __('ISBN/ISSN'); ?></option><option value="publisher"><?php echo __('Publisher'); ?></option></select>
    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
}
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'.__('You are not authorized to view this section').'</div>');
    }
    /* RECORD FORM */
    // try query
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $_sql_rec_q = sprintf('SELECT b.*, p.publisher_name, pl.place_name FROM biblio AS b
        LEFT JOIN mst_publisher AS p ON b.publisher_id=p.publisher_id
        LEFT JOIN mst_place AS pl ON b.publish_place_id=pl.place_id
        WHERE biblio_id=%d', $itemID);
    $rec_q = $dbs->query($_sql_rec_q);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.__('Save').'" class="button"';
    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    $visibility = 'makeVisible';
    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        if (!$in_pop_up) {
            // form record id
            $form->record_id = $itemID;
        } else {
            $form->addHidden('updateRecordID', $itemID);
            $form->addHidden('itemCollID', $_POST['itemCollID']);
            $form->back_button = false;
        }
        // form record title
        $form->record_title = $rec_d['title'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.__('Update').'" class="button"';
        // element visibility class toogle
        $visibility = 'makeHidden';

        // custom field data query
        $_sql_rec_cust_q = sprintf('SELECT * FROM biblio_custom WHERE biblio_id=%d', $itemID);
        $rec_cust_q = $dbs->query($_sql_rec_cust_q);
        $rec_cust_d = $rec_cust_q->fetch_assoc();
    }

    // include custom fields file
    if (file_exists(MODULES_BASE_DIR.'bibliography/custom_fields.inc.php')) {
        include MODULES_BASE_DIR.'bibliography/custom_fields.inc.php';
    }

    /* Form Element(s) */
    // biblio title
    $form->addTextField('textarea', 'title', __('Title').'*', $rec_d['title'], 'rows="1" style="width: 100%; overflow: auto;"');
    // biblio edition
    $form->addTextField('text', 'edition', __('Edition'), $rec_d['edition'], 'style="width: 40%;"');
    // biblio specific detail info/area
    $form->addTextField('textarea', 'specDetailInfo', __('Specific Detail Info'), $rec_d['spec_detail_info'], 'rows="2" style="width: 100%"');
    // biblio item add
    if (!$in_pop_up AND $form->edit_mode) {
        $str_input = '<div class="makeHidden"><a class="notAJAX" href="javascript: openHTMLpop(\''.MODULES_WEB_ROOT_DIR.'bibliography/pop_item.php?inPopUp=true&action=detail&biblioID='.$rec_d['biblio_id'].'\', 650, 400, \''.__('Items/Copies').'\')">'.__('Add New Items').'</a></div>';
        $str_input .= '<iframe name="itemIframe" id="itemIframe" class="borderAll" style="width: 100%; height: 70px;" src="'.MODULES_WEB_ROOT_DIR.'bibliography/iframe_item_list.php?biblioID='.$rec_d['biblio_id'].'&block=1"></iframe>'."\n";
        $form->addAnything('Item(s) Data', $str_input);
    }
    // biblio authors
        $str_input = '<div class="'.$visibility.'"><a class="notAJAX" href="javascript: openHTMLpop(\''.MODULES_WEB_ROOT_DIR.'bibliography/pop_author.php?biblioID='.$rec_d['biblio_id'].'\', 500, 200, \''.__('Authors/Roles').'\')">'.__('Add Author(s)').'</a></div>';
        $str_input .= '<iframe name="authorIframe" id="authorIframe" class="borderAll" style="width: 100%; height: 70px;" src="'.MODULES_WEB_ROOT_DIR.'bibliography/iframe_author.php?biblioID='.$rec_d['biblio_id'].'&block=1"></iframe>';
    $form->addAnything(__('Author(s)'), $str_input);
    // biblio gmd
        // get gmd data related to this record from database
        $gmd_q = $dbs->query('SELECT gmd_id, gmd_name FROM mst_gmd');
        $gmd_options = array();
        while ($gmd_d = $gmd_q->fetch_row()) {
            $gmd_options[] = array($gmd_d[0], $gmd_d[1]);
        }
    $form->addSelectList('gmdID', __('GMD'), $gmd_options, $rec_d['gmd_id']);
    // biblio publish frequencies
        // get frequency data related to this record from database
        $freq_q = $dbs->query('SELECT frequency_id, frequency FROM mst_frequency');
        $freq_options[] = array('0', strtoupper(__('Not Applicable')));
        while ($freq_d = $freq_q->fetch_row()) {
            $freq_options[] = array($freq_d[0], $freq_d[1]);
        }
        $str_input = simbio_form_element::selectList('frequencyID', $freq_options, $rec_d['frequency_id']);
        $str_input .= '&nbsp;';
        $str_input .= ' '.__('Use this for Serial publication');
    $form->addAnything(__('Frequency'), $str_input);
    // biblio ISBN/ISSN
    $form->addTextField('text', 'isbn_issn', __('ISBN/ISSN'), $rec_d['isbn_issn'], 'style="width: 40%;"');
    // biblio classification
    $form->addTextField('text', 'class', __('Classification'), $rec_d['classification'], 'style="width: 40%;"');
    // biblio publisher
        // AJAX expression
        $ajax_exp = "ajaxFillSelect('".SENAYAN_WEB_ROOT_DIR."admin/AJAX_lookup_handler.php', 'mst_publisher', 'publisher_id:publisher_name', 'publisherID', $('#publ_search_str').val())";
        if ($rec_d['publisher_name']) {
            $publ_options[] = array($rec_d['publisher_id'], $rec_d['publisher_name']);
        }
        $publ_options[] = array('0', __('Publisher'));
        // string element
        $str_input = simbio_form_element::selectList('publisherID', $publ_options, '', 'style="width: 50%;"');
        $str_input .= '&nbsp;';
        $str_input .= simbio_form_element::textField('text', 'publ_search_str', $rec_d['publisher_name'], 'style="width: 45%;" onkeyup="'.$ajax_exp.'"');
    $form->addAnything(__('Publisher'), $str_input);
    // biblio publish year
    $form->addTextField('text', 'year', __('Publishing Year'), $rec_d['publish_year'], 'style="width: 40%;"');
    // biblio publish place
        // AJAX expression
        $ajax_exp = "ajaxFillSelect('".SENAYAN_WEB_ROOT_DIR."admin/AJAX_lookup_handler.php', 'mst_place', 'place_id:place_name', 'placeID', $('#plc_search_str').val())";
        // string element
        if ($rec_d['place_name']) {
            $plc_options[] = array($rec_d['publish_place_id'], $rec_d['place_name']);
        }
        $plc_options[] = array('0', __('Publishing Place'));
        $str_input = simbio_form_element::selectList('placeID', $plc_options, '', 'style="width: 50%;"');
        $str_input .= '&nbsp;';
        $str_input .= simbio_form_element::textField('text', 'plc_search_str', $rec_d['place_name'], 'style="width: 45%;" onkeyup="'.$ajax_exp.'"');
    $form->addAnything(__('Publishing Place'), $str_input);
    // biblio collation
    $form->addTextField('text', 'collation', __('Collation'), $rec_d['collation'], 'style="width: 40%;"');
    // biblio series title
    $form->addTextField('textarea', 'seriesTitle', __('Series Title'), $rec_d['series_title'], 'rows="1" style="width: 100%;"');
    // biblio call_number
    $form->addTextField('text', 'callNumber', __('Call Number'), $rec_d['call_number'], 'style="width: 40%;"');
    // biblio topics
        $str_input = '<div class="'.$visibility.'"><a class="notAJAX"  href="javascript: openHTMLpop(\''.MODULES_WEB_ROOT_DIR.'bibliography/pop_topic.php?biblioID='.$rec_d['biblio_id'].'\', 500, 200, \''.__('Subjects/Topics').'\')">'.__('Add Subject(s)').'</a></div>';
        $str_input .= '<iframe name="topicIframe" id="topicIframe" class="borderAll" style="width: 100%; height: 70px;" src="'.MODULES_WEB_ROOT_DIR.'bibliography/iframe_topic.php?biblioID='.$rec_d['biblio_id'].'&block=1"></iframe>';
    $form->addAnything(__('Subject(s)'), $str_input);
    // biblio language
        // get language data related to this record from database
        $lang_q = $dbs->query("SELECT language_id, language_name FROM mst_language");
        $lang_options = array();
        while ($lang_d = $lang_q->fetch_row()) {
            $lang_options[] = array($lang_d[0], $lang_d[1]);
        }
    $form->addSelectList('languageID', __('Language'), $lang_options, $rec_d['language_id']);
    // biblio note
    $form->addTextField('textarea', 'notes', __('Abstract/Notes'), $rec_d['notes'], 'style="width: 100%;" rows="2"');
    // biblio cover image
    if (!trim($rec_d['image'])) {
        $str_input = simbio_form_element::textField('file', 'image');
        $str_input .= ' Maximum '.$sysconf['max_image_upload'].' KB';
        $form->addAnything(__('Image'), $str_input);
    } else {
        $str_input = '<a href="'.SENAYAN_WEB_ROOT_DIR.'images/docs/'.$rec_d['image'].'" target="_blank"><strong>'.$rec_d['image'].'</strong></a><br />';
        $str_input .= simbio_form_element::textField('file', 'image');
        $str_input .= ' Maximum '.$sysconf['max_image_upload'].' KB';
        $form->addAnything(__('Image'), $str_input);
    }
    // biblio file attachment
    $str_input = '<div class="'.$visibility.'"><a class="notAJAX" href="javascript: openHTMLpop(\''.MODULES_WEB_ROOT_DIR.'bibliography/pop_attach.php?biblioID='.$rec_d['biblio_id'].'\', 600, 300, \''.__('File Attachments').'\')">'.__('Add Attachment').'</a></div>';
    $str_input .= '<iframe name="attachIframe" id="attachIframe" class="borderAll" style="width: 100%; height: 70px;" src="'.MODULES_WEB_ROOT_DIR.'bibliography/iframe_attach.php?biblioID='.$rec_d['biblio_id'].'&block=1"></iframe>';
    $form->addAnything(__('File Attachment'), $str_input);

    /**
     * Custom fields
     */
    if (isset($biblio_custom_fields)) {
        if (is_array($biblio_custom_fields) && $biblio_custom_fields) {
            foreach ($biblio_custom_fields as $fid => $cfield) {

                // custom field properties
                $cf_dbfield = $cfield['dbfield'];
                $cf_label = $cfield['label'];
                $cf_default = $cfield['default'];
                $cf_data = (isset($cfield['data']) && $cfield['data'])?$cfield['data']:array();

                // custom field processing
                if (in_array($cfield['type'], array('text', 'longtext', 'numeric'))) {
                    $cf_max = isset($cfield['max'])?$cfield['max']:'200';
                    $cf_width = isset($cfield['width'])?$cfield['width']:'50';
                    $form->addTextField( ($cfield['type'] == 'longtext')?'textarea':'text', $cf_dbfield, $cf_label, isset($rec_cust_d[$cf_dbfield])?$rec_cust_d[$cf_dbfield]:$cf_default, 'style="width: '.$cf_width.'%;" maxlength="'.$cf_max.'"');
                } else if ($cfield['type'] == 'dropdown') {
                    $form->addSelectList($cf_dbfield, $cf_label, $cf_data, isset($rec_cust_d[$cf_dbfield])?$rec_cust_d[$cf_dbfield]:$cf_default);
                } else if ($cfield['type'] == 'checklist') {
                    $form->addCheckBox($cf_dbfield, $cf_label, $cf_data, isset($rec_cust_d[$cf_dbfield])?$rec_cust_d[$cf_dbfield]:$cf_default);
                } else if ($cfield['type'] == 'choice') {
                    $form->addRadio($cf_dbfield, $cf_label, $cf_data, isset($rec_cust_d[$cf_dbfield])?$rec_cust_d[$cf_dbfield]:$cf_default);
                } else if ($cfield['type'] == 'date') {
                    $form->addDateField($cf_dbfield, $cf_label, isset($rec_cust_d[$cf_dbfield])?$rec_cust_d[$cf_dbfield]:$cf_default);
                }
            }
        }
    }

    // biblio hide from opac
    $hide_options[] = array('0', __('Show'));
    $hide_options[] = array('1', __('Hide'));
    $form->addRadio('opacHide', __('Hide in OPAC'), $hide_options, $rec_d['opac_hide']?'1':'0');
    // biblio promote to front page
    $promote_options[] = array('0', __('Don\'t Promote'));
    $promote_options[] = array('1', __('Promote'));
    $form->addRadio('promote', __('Promote To Homepage'), $promote_options, $rec_d['promoted']?'1':'0');
    // biblio labels
        $arr_labels = !empty($rec_d['labels'])?unserialize($rec_d['labels']):array();
        if ($arr_labels) {
            foreach ($arr_labels as $label) { $arr_labels[$label[0]] = $label[1]; }
        }
        $str_input = '';
        // get label data from database
        $label_q = $dbs->query("SELECT * FROM mst_label LIMIT 20");
        while ($label_d = $label_q->fetch_assoc()) {
            $checked = isset($arr_labels[$label_d['label_name']])?' checked':'';
            $url = isset($arr_labels[$label_d['label_name']])?$arr_labels[$label_d['label_name']]:'';
            $str_input .= '<div '
                .'style="background: url('.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/labels/'.$label_d['label_image'].') left center no-repeat; padding-left: 30px; height: 45px;"> '
                .'<input type="checkbox" name="labels[]" value="'.$label_d['label_name'].'"'.$checked.' /> '.$label_d['label_desc']
                .'<div>URL : <input type="text" title="Enter a website link/URL to make this label clickable" '
                .'name="label_urls['.$label_d['label_name'].']" size="50" maxlength="300" value="'.$url.'" /></div></div>';
        }
    $form->addAnything('Label', $str_input);
    // $form->addCheckBox('labels', 'Label', $label_options, explode(' ', $rec_d['labels']));

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox" style="overflow: auto;">'
            .'<div style="float: left; width: 80%;">'.__('You are going to edit biblio data').' : <b>'.$rec_d['title'].'</b>  <br />'.__('Last Updated').$rec_d['last_update'].'</div>'; //mfc
            if ($rec_d['image']) {
                if (file_exists(IMAGES_BASE_DIR.'docs/'.$rec_d['image'])) {
                    $upper_dir = '';
                    if ($in_pop_up) {
                        $upper_dir = '../../';
                    }
                    echo '<div style="float: right;"><img src="'.$upper_dir.'../lib/phpthumb/phpThumb.php?src=../../images/docs/'.urlencode($rec_d['image']).'&w=53" style="border: 1px solid #999999" /></div>';
                }
            }
        echo '</div>'."\n";
    }
    // print out the form object
    echo $form->printOut();
} else {
    require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_tokenizecql.inc.php';
    require MODULES_BASE_DIR.'bibliography/biblio_utils.inc.php';
    require LIB_DIR.'biblio_list_model.inc.php';

    // number of records to show in list
    $biblio_result_num = ($sysconf['biblio_result_num']>100)?100:$sysconf['biblio_result_num'];

    // create datagrid
    $datagrid = new simbio_datagrid();

    // index choice
    if ($sysconf['index']['type'] == 'index' ||  $sysconf['index']['type'] == 'sphinx' ) {
        if ($sysconf['index']['type'] == 'sphinx') {
            require LIB_DIR.'sphinx/sphinxapi.php';
            require LIB_DIR.'biblio_list_sphinx.inc.php';
        } else {
            require LIB_DIR.'biblio_list_index.inc.php';
        }

        // table spec
        $table_spec = 'search_biblio AS `index` LEFT JOIN item ON `index`.biblio_id=item.biblio_id';

        if ($can_read AND $can_write) {
            $datagrid->setSQLColumn('index.biblio_id', 'index.title AS \''.__('Title').'\'', 'index.labels',
                'index.author',
                'index.isbn_issn AS \''.__('ISBN/ISSN').'\'',
                'IF(COUNT(item.item_id)>0, COUNT(item.item_id), \'<strong style="color: #f00;">'.__('None').'</strong>\') AS \''.__('Copies').'\'',
                'index.last_update AS \''.__('Last Update').'\'');
            $datagrid->modifyColumnContent(1, 'callback{showTitleAuthors}');
        } else {
            $datagrid->setSQLColumn('index.title AS \''.__('Title').'\'', 'index.author', 'index.labels',
                'index.isbn_issn AS \''.__('ISBN/ISSN').'\'',
                'IF(COUNT(item.item_id)>0, COUNT(item.item_id), \'<strong style="color: #f00;">'.__('None').'</strong>\') AS \''.__('Copies').'\'',
                'index.last_update AS \''.__('Last Update').'\'');
            $datagrid->modifyColumnContent(1, 'callback{showTitleAuthors}');
        }
        $datagrid->invisible_fields = array(1,2);
        $datagrid->setSQLorder('index.last_update DESC');

        // set group by
        $datagrid->sql_group_by = 'index.biblio_id';

    } else {
        require LIB_DIR.'biblio_list.inc.php';

        // table spec
        $table_spec = 'biblio LEFT JOIN item ON biblio.biblio_id=item.biblio_id';

        if ($can_read AND $can_write) {
            $datagrid->setSQLColumn('biblio.biblio_id', 'biblio.biblio_id AS bid',
                'biblio.title AS \''.__('Title').'\'',
                'biblio.isbn_issn AS \''.__('ISBN/ISSN').'\'',
                'IF(COUNT(item.item_id)>0, COUNT(item.item_id), \'<strong style="color: #f00;">'.__('None').'</strong>\') AS \''.__('Copies').'\'',
                'biblio.last_update AS \''.__('Last Update').'\'');
            $datagrid->modifyColumnContent(2, 'callback{showTitleAuthors}');
        } else {
            $datagrid->setSQLColumn('biblio.biblio_id AS bid', 'biblio.title AS \''.__('Title').'\'',
                'biblio.isbn_issn AS \''.__('ISBN/ISSN').'\'',
                'IF(COUNT(item.item_id)>0, COUNT(item.item_id), \'<strong style="color: #f00;">'.__('None').'</strong>\') AS \''.__('Copies').'\'',
                'biblio.last_update AS \''.__('Last Update').'\'');
            // modify column value
            $datagrid->modifyColumnContent(1, 'callback{showTitleAuthors}');
        }
        $datagrid->invisible_fields = array(0);
        $datagrid->setSQLorder('biblio.last_update DESC');

        // set group by
        $datagrid->sql_group_by = 'biblio.biblio_id';
    }

	$stopwords= "@\sAnd\s|\sOr\s|\sNot\s|\sThe\s|\sDan\s|\sAtau\s|\sAn\s|\sA\s@i";

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $keywords = $dbs->escape_string(trim($_GET['keywords']));
		$keywords = preg_replace($stopwords,' ',$keywords);
        $searchable_fields = array('title', 'author', 'subject', 'isbn', 'publisher');
        if ($_GET['field'] != '0' AND in_array($_GET['field'], $searchable_fields)) {
            $field = $_GET['field'];
            $search_str = $field.'='.$keywords;
        } else {
            $search_str = '';
            foreach ($searchable_fields as $search_field) {
                $search_str .= $search_field.'='.$keywords.' OR ';
            }
            $search_str = substr_replace($search_str, '', -4);
        }

        $biblio_list = new biblio_list($dbs, $biblio_result_num);
        $criteria = $biblio_list->setSQLcriteria($search_str);
    }

    if (isset($criteria)) {
        $datagrid->setSQLcriteria('('.$criteria['sql_criteria'].')');
    }

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid->debug = true;

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, $biblio_result_num, ($can_read AND $can_write));
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"<div>'.__('Query took').' <b>'.$datagrid->query_time.'</b> '.__('second(s) to complete').'</div></div>'; //mfc
    }

    echo $datagrid_result;
}
/* main content end */
?>
