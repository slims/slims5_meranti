<?php
/**
 * biblio_list class
 * Class for generating list of bibliographic records
 *
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


class biblio_list
{
    /* Private properties */
    private $obj_db = false;
    private $resultset = false;
    private $num2show = 10;
    private $subquery = array();
    private $biblio_ids = array();
    private $emulate_short_word_search = false;
    private $queries_word_num_allowed = 20;
    private $query_error;
    /* Public properties */
    public $num_rows = 0;
    public $xml_detail = true;
    public $xml_result = true;
    public $only_promoted = false;
    public $show_labels = true;
    public $stop_words = array('a', 'an', 'of', 'the', 'to', 'so', 'as', 'be');
    public $query_time = 0;
    /* Protected properties */
    protected $criteria = array();
    protected $label_cache = array();
    protected $custom_fields = array();
    protected $enable_custom_frontpage = false;
    protected $orig_query;
    protected $searchable_fields = array('title', 'author', 'subject', 'isbn', 'publisher', 'gmd', 'notes', 'colltype', 'location');
    protected $field_join_type = array('title' => 'OR', 'author' => 'OR', 'subject' => 'OR');
    protected $current_page = 1;


    /**
     * Class Constructor
     *
     * @param   object  $obj_db
     */
    public function __construct($obj_db)
    {
        $this->obj_db = $obj_db;
    }


    /**
     * Method to set search criteria
     *
     * @param   string  $str_criteria
     * @return  void
     */
    public function setSQLcriteria($str_criteria)
    {
        // defaults
        $_sql_criteria = '';
        $_searched_fields = array();
        $_title_buffer = '';
        $_previous_field = '';
        $_boolean = '';
        // parse query
        $this->orig_query = $str_criteria;
        $_queries = simbio_tokenizeCQL($str_criteria, $this->searchable_fields, $this->stop_words, $this->queries_word_num_allowed);
        // var_dump($_queries);
        if (count($_queries) < 1) {
            return null;
        }
        // loop each query
        foreach ($_queries as $_num => $_query) {
            // field
            $_field = $_query['f'];
            // for debugging purpose only
            // echo "<p>$_num. $_field -> $_boolean -> $_sql_criteria</p><p>&nbsp;</p>";
            // boolean
            if ($_title_buffer == '' && $_field != 'boolean') {
                $_sql_criteria .= " $_boolean ";
            }
            // $_sql_criteria .= " $_boolean ";
            // flush title string concatenation
            if ($_field != 'title' && $_title_buffer != '') {
                $_title_buffer = trim($_title_buffer);
                $_sql_criteria .= " biblio.biblio_id IN(SELECT DISTINCT biblio_id FROM biblio WHERE MATCH (title, series_title) AGAINST ('$_title_buffer' IN BOOLEAN MODE)) ";
                // reset title buffer
                $_title_buffer = '';
            }
            //  break the loop if we meet `cql_end` field
            if ($_field == 'cql_end') { break; }
            // boolean mode
            $_b = isset($_query['b'])?$_query['b']:$_query;
            if ($_b == '*') {
                $_boolean = 'OR';
            } else { $_boolean = 'AND'; }
            // search value
            $_q = @$this->obj_db->escape_string($_query['q']);
            // searched fields flag set
            $_searched_fields[$_field] = 1;
            $_previous_field = $_field;
            // check field
            if ($_field == 'title') {
                if (strlen($_q) < 4) {
                    $_previous_field = 'title_short';
                    $_sql_criteria .= " biblio.title LIKE '%$_q%' ";
                    $_title_buffer = '';
                } else {
                    if (isset($_query['is_phrase'])) {
                        $_title_buffer .= ' '.$_b.'"'.$_q.'"';
                    } else {
                        $_title_buffer .= ' '.$_b.$_q;
                    }
                }
            } else if ($_field == 'author') {
                if ($_b == '-') {
                    $_sql_criteria .= " biblio.biblio_id NOT IN(SELECT ba.biblio_id FROM biblio_author AS ba"
                        ." LEFT JOIN mst_author AS a ON ba.author_id=a.author_id"
                        ." WHERE author_name LIKE '%$_q%')";
                } else {
                    $_sql_criteria .= " biblio.biblio_id IN(SELECT ba.biblio_id FROM biblio_author AS ba"
                        ." LEFT JOIN mst_author AS a ON ba.author_id=a.author_id"
                        ." WHERE author_name LIKE '%$_q%')";
                }
            } else if ($_field == 'subject') {
                if ($_b == '-') {
                    $_sql_criteria .= " biblio.biblio_id NOT IN(SELECT bt.biblio_id FROM biblio_topic AS bt"
                        ." LEFT JOIN mst_topic AS t ON bt.topic_id=t.topic_id"
                        ." WHERE topic LIKE '%$_q%')";
                } else {
                    $_sql_criteria .= " biblio.biblio_id IN(SELECT bt.biblio_id FROM biblio_topic AS bt"
                        ." LEFT JOIN mst_topic AS t ON bt.topic_id=t.topic_id"
                        ." WHERE topic LIKE '%$_q%')";
                }
                // reset title buffer
                $_title_buffer = '';
            } else {
                switch ($_field) {
                    case 'location' :
                        $_subquery = 'SELECT location_id FROM mst_location WHERE location_name=\''.$_q.'\'';
                        if ($_b == '-') {
                            $_sql_criteria .= " item.location_id NOT IN ($_subquery)";
                        } else { $_sql_criteria .= " item.location_id IN ($_subquery)"; }
                        break;
                    case 'colltype' :
                        $_subquery = 'SELECT coll_type_id FROM mst_coll_type WHERE coll_type_name=\''.$_q.'\'';
                        if ($_b == '-') {
                            $_sql_criteria .= " item.coll_type_id NOT IN ($_subquery)";
                        } else { $_sql_criteria .= " item.coll_type_id IN ($_subquery)"; }
                        break;
                    case 'itemcode' :
                        if ($_b == '-') {
                            $_sql_criteria .= " item.item_code != '$_q'";
                        } else { $_sql_criteria .= " item.item_code LIKE '$_q%'"; }
                        break;
                    case 'callnumber' :
                        if ($_b == '-') {
                            $_sql_criteria .= ' AND biblio.call_number NOT LIKE \''.$_q.'%\'';
                        } else { $_sql_criteria .= ' biblio.call_number LIKE \''.$_q.'%\''; }
                        break;
                    case 'itemcallnumber' :
                        if ($_b == '-') {
                            $_sql_criteria .= ' AND item.call_number NOT LIKE \''.$_q.'%\'';
                        } else { $_sql_criteria .= ' item.call_number LIKE \''.$_q.'%\''; }
                        break;
                    case 'class' :
                        if ($_b == '-') {
                            $_sql_criteria .= ' AND biblio.classification NOT LIKE \''.$_q.'%\'';
                        } else { $_sql_criteria .= ' biblio.classification LIKE \''.$_q.'%\''; }
                        break;
                    case 'isbn' :
                        if ($_b == '-') {
                            $_sql_criteria .= ' AND biblio.isbn_issn!=\''.$_q.'\'';
                        } else { $_sql_criteria .= ' biblio.isbn_issn=\''.$_q.'\''; }
                        break;
                    case 'publisher' :
                        $_subquery = 'SELECT publisher_id FROM mst_publisher WHERE publisher_name=\''.$_q.'\'';
                        if ($_b == '-') {
                            $_sql_criteria .= " biblio.publisher_id NOT IN ($_subquery)";
                        } else { $_sql_criteria .= " biblio.publisher_id IN ($_subquery)"; }
                        break;
                    case 'gmd' :
                        $_subquery = 'SELECT gmd_id FROM mst_gmd WHERE gmd_name=\''.$_q.'\'';
                        if ($_b == '-') {
                            $_sql_criteria .= " biblio.gmd_id NOT IN ($_subquery)";
                        } else { $_sql_criteria .= " biblio.gmd_id IN ($_subquery)"; }
                        break;
                    case 'notes' :
                        if ($_b == '-') {
                            $_sql_criteria .= " NOT (MATCH (biblio.notes) AGAINST ('".$_q."', IN BOOLEAN MODE))";
                        } else { $_sql_criteria .= " (MATCH (biblio.notes) AGAINST ('".$_q."', IN BOOLEAN MODE))"; }
                        break;
                }
            }
        }

        // remove boolean's logic symbol prefix and suffix
        $_sql_criteria = preg_replace('@^(AND|OR|NOT)\s*|\s+(AND|OR|NOT)$@i', '', trim($_sql_criteria));
        // below for debugging purpose only
        // echo "<div style=\"border: 1px solid #ff0000; padding: 5px; color: #ff0000; margin: 5px;\">$_sql_criteria</div>";

        $this->criteria = array('sql_criteria' => $_sql_criteria, 'searched_fields' => $_searched_fields);
        return $this->criteria;
    }


    /**
     * Method to print out document records
     *
     * @param   object  $obj_db
     * @param   integer $int_num2show
     * @param   boolean $bool_return_output
     * @return  string
     */
    public function getDocumentList($int_num2show = 10, $bool_return_output = true)
    {
        global $sysconf;
        $this->num2show = $int_num2show;
        // get page number from http get var
        if (!isset($_GET['page']) OR $_GET['page'] < 1){
            $_page = 1;
        } else{
            $_page = (integer)$_GET['page'];
        }
        $this->current_page = $_page;

        // count the row offset
        if ($_page <= 1) {
            $_offset = 0;
        } else {
            $_offset = ($_page*$this->num2show) - $this->num2show;
        }

        // init sql string
        $_sql_str = 'SELECT SQL_CALC_FOUND_ROWS biblio.biblio_id, biblio.title, biblio.image, biblio.labels';

        // checking custom frontpage fields file
        $custom_frontpage_record_file = SENAYAN_BASE_DIR.$sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/custom_frontpage_record.inc.php';
        if (file_exists($custom_frontpage_record_file)) {
            include $custom_frontpage_record_file;
            $this->enable_custom_frontpage = true;
            $this->custom_fields = $custom_fields;
            foreach ($this->custom_fields as $_field => $_field_opts) {
                if ($_field_opts[0] == 1 && $_field != 'availability') {
                    $_sql_str .= ", biblio.$_field";
                }
            }
        }

        // additional SQL string
        $_add_sql_str = '';

        // location
        if ($this->criteria) {
            if (isset($this->criteria['searched_fields']['location']) OR isset($this->criteria['searched_fields']['colltype'])) {
                $_add_sql_str .= ' LEFT JOIN item ON b.biblio_id=i.biblio_id ';
            }
        }

        $_add_sql_str .= ' WHERE opac_hide=0 ';
        // promoted flag
        if ($this->only_promoted) { $_add_sql_str .= ' AND promoted=1'; }
        // main search criteria
        if ($this->criteria) {
            $_add_sql_str .= ' AND ('.$this->criteria['sql_criteria'].') ';
        }

        $_sql_str .= ' FROM biblio '.$_add_sql_str.' ORDER BY biblio.last_update DESC LIMIT '.$_offset.', '.$this->num2show;
        // for debugging purpose only
        // echo "<div style=\"border: 1px solid navy; padding: 5px; color: navy; margin: 5px;\">$_sql_str</div>";
        // start time
        $_start = function_exists('microtime')?microtime(true):time();
        // execute query
        $this->resultset = $this->obj_db->query($_sql_str);
        if ($this->obj_db->error) {
            $this->query_error = $this->obj_db->error;
        }
        // get total number of rows from query
        $_total_q = $this->obj_db->query('SELECT FOUND_ROWS()');
        $_total_d = $_total_q->fetch_row();
        $this->num_rows = $_total_d[0];
        // end time
        $_end = function_exists('microtime')?microtime(true):time();
        $this->query_time = round($_end-$_start, 5);
        if ($bool_return_output) {
            // return the html result
            return $this->makeOutput();
        }
    }


    /**
     * Method to make an output of document records
     *
     * @return  string
     */
    protected function makeOutput()
    {
        global $sysconf;
        // init the result buffer
        $_buffer = '';

        // loop data
        $_i = 0;
        if (!$this->resultset) {
            return '<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px; margin: 5px;">Query error : '.$this->query_error.'</div>';
        }
        while ($_biblio_d = $this->resultset->fetch_assoc()) {
            $_biblio_d['title'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&id='.$_biblio_d['biblio_id'].'" title="'.__('Record Detail').'">'.$_biblio_d['title'].'</a>';
            // label
            if ($this->show_labels AND !empty($_biblio_d['labels'])) {
                $arr_labels = @unserialize($_biblio_d['labels']);
                if ($arr_labels !== false) {
	                foreach ($arr_labels as $label) {
	                    if (!isset($this->label_cache[$label[0]]['name'])) {
	                        $_label_q = $this->obj_db->query('SELECT label_name, label_desc, label_image FROM mst_label AS lb
	                            WHERE lb.label_name=\''.$label[0].'\'');
	                        $_label_d = $_label_q->fetch_row();
	                        $this->label_cache[$label[0]] = array('name' => $_label_d[0], 'desc' => $_label_d[1], 'image' => $_label_d[2]);
	                    }
	                    if (isset($label[1]) && $label[1]) {
	                        $_biblio_d['title'] .= ' <a href="'.$label[1].'" target="_blank"><img src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/labels/'.$this->label_cache[$label[0]]['image'].'" title="'.$this->label_cache[$label[0]]['desc'].'" align="middle" class="labels" border="0" /></a>';
	                    } else {
	                        $_biblio_d['title'] .= ' <img src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/labels/'.$this->label_cache[$label[0]]['image'].'" title="'.$this->label_cache[$label[0]]['desc'].'" align="middle" class="labels" />';
	                    }
	                }
								}
            }
            // button
            $_biblio_d['detail_button'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&id='.$_biblio_d['biblio_id'].'" class="detailLink" title="'.__('Record Detail').'">'.__('Record Detail').'</a>';
            if ($this->xml_detail) {
                $_biblio_d['xml_button'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&inXML=true&id='.$_biblio_d['biblio_id'].'" class="xmlDetailLink" title="View Detail in XML Format" target="_blank">XML Detail</a>';
            } else {
                $_biblio_d['xml_button'] = '';
            }

            // cover images var
            $_image_cover = '';
            if (!empty($_biblio_d['image']) && !defined('LIGHTWEIGHT_MODE')) {
                $_biblio_d['image'] = urlencode($_biblio_d['image']);
                $images_loc = 'images/docs/'.$_biblio_d['image'];
                if (file_exists($images_loc)) {
                    $_image_cover = 'style="background-image: url(./lib/phpthumb/phpThumb.php?src=../../'.$images_loc.'&w=42); background-repeat: no-repeat;"';
                }
            }

            $_alt_list = ($_i%2 == 0)?'alterList':'alterList2';
            $_buffer .= '<div class="item '.$_alt_list.'" '.$_image_cover.'>'.$_biblio_d['title'].'<br />';
            // query the author
            $_author_q = $this->obj_db->query('SELECT a.author_name FROM biblio_author AS ba
                LEFT JOIN biblio AS b ON ba.biblio_id=b.biblio_id
                LEFT JOIN mst_author AS a ON ba.author_id=a.author_id WHERE ba.biblio_id='.$_biblio_d['biblio_id']);
            // concat author data
            $_authors = '';
            while ($_author_d = $_author_q->fetch_row()) {
                $_authors .= $_author_d[0].' - ';
            }
            if ($_authors) {
                // replace the last strip
                $_authors = substr_replace($_authors, '', -3);
                $_buffer .= '<div class="subItem authorField"><b>'.__('Author(s)').'</b> : '.$_authors.'</div>';
            }

            # checking custom file
            if ($this->enable_custom_frontpage AND $this->custom_fields) {
                foreach ($this->custom_fields as $_field => $_field_opts) {
                    if ($_field_opts[0] == 1) {
                        if ($_field == 'edition') {
                            $_buffer .= '<div class="customField editionField"><b>'.$_field_opts[1].'</b> : '.$_biblio_d['edition'].'</div>';
                        } else if ($_field == 'isbn_issn') {
                            $_buffer .= '<div class="customField isbnField"><b>'.$_field_opts[1].'</b> : '.$_biblio_d['isbn_issn'].'</div>';
                        } else if ($_field == 'collation') {
                            $_buffer .= '<div class="customField collationField"><b>'.$_field_opts[1].'</b> : '.$_biblio_d['collation'].'</div>';
                        } else if ($_field == 'series_title') {
                            $_buffer .= '<div class="customField seriesTitleField"><b>'.$_field_opts[1].'</b> : '.$_biblio_d['series_title'].'</div>';
                        } else if ($_field == 'call_number') {
                            $_buffer .= '<div class="customField callNumberField"><b>'.$_field_opts[1].'</b> : '.$_biblio_d['call_number'].'</div>';
                        } else if ($_field == 'availability') {
                            // get total number of this biblio items/copies
                            $_item_q = $this->obj_db->query('SELECT COUNT(*) FROM item WHERE biblio_id='.$_biblio_d['biblio_id']);
                            $_item_c = $_item_q->fetch_row();
                            // get total number of currently borrowed copies
                            $_borrowed_q = $this->obj_db->query('SELECT COUNT(*) FROM loan AS l INNER JOIN item AS i'
                                .' ON l.item_code=i.item_code WHERE l.is_lent=1 AND l.is_return=0 AND i.biblio_id='.$_biblio_d['biblio_id']);
                            $_borrowed_c = $_borrowed_q->fetch_row();
                            // total available
                            $_total_avail = $_item_c[0]-$_borrowed_c[0];
                            if ($_total_avail < 1) {
                                $_buffer .= '<div class="customField availabilityField"><b>'.$_field_opts[1].'</b> : <strong style="color: #FF0000;">none copy available</strong></div>';
                            } else {
                                $_buffer .= '<div class="customField availabilityField"><b>'.$_field_opts[1].'</b> : '.$_total_avail.' copies available for loan</div>';
                            }
                        }
                    }
                }
            }

            $_buffer .= '<div class="subItem">'.$_biblio_d['detail_button'].' '.$_biblio_d['xml_button'].'</div>';
            $_buffer .= "</div>\n";
            $_i++;
        }

        // free resultset memory
        $this->resultset->free_result();

        // paging
        if (($this->num_rows > $this->num2show)) {
            $_paging = '<hr width="97%" size="1" />'."\n";
            $_paging .= '<div style="text-align: center;">'.simbio_paging::paging($this->num_rows, $this->num2show, 5).'</div>';
        } else {
            $_paging = '';
        }

        return $_buffer.$_paging;
    }



    /**
     * Method to make an output of document records in simple XML format
     *
     * @return  string
     */
    public function XMLresult()
    {
        global $sysconf;
        // loop data
        $_buffer = '<modsCollection xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.loc.gov/mods/v3" xsi:schemaLocation="http://www.loc.gov/mods/v3 http://www.loc.gov/standards/mods/v3/mods-3-3.xsd">'."\n";
        $_buffer .= '<modsResultNum>'.$this->num_rows.'</modsResultNum>'."\n";
        $_buffer .= '<modsResultPage>'.$this->current_page.'</modsResultPage>'."\n";
        $_buffer .= '<modsResultShowed>'.$this->num2show.'</modsResultShowed>'."\n";
        while ($_biblio_d = $this->resultset->fetch_assoc()) {
            $_buffer .= '<mods ID="'.$_biblio_d['biblio_id'].'">'."\n";
            // parse title
            $_title_sub = '';
            if (stripos($_biblio_d['title'], ':') !== false) {
                $_title_main = trim(substr_replace($_biblio_d['title'], '', stripos($_biblio_d['title'], ':')+1));
                $_title_sub = trim(substr_replace($_biblio_d['title'], '', 0, stripos($_biblio_d['title'], ':')+1));
            } else {
                $_title_main = trim($_biblio_d['title']);
            }

            $_buffer .= '<titleInfo>'."\n".'<title>'.$_title_main.'</title>'."\n";
            if ($_title_sub) {
                $_buffer .= '<subTitle>'.$_title_sub.'</subTitle>'."\n";
            }
            $_buffer .= '</titleInfo>'."\n";

            // get the authors data
            $_biblio_authors_q = $this->obj_db->query('SELECT a.*,ba.level FROM mst_author AS a'
                .' LEFT JOIN biblio_author AS ba ON a.author_id=ba.author_id WHERE ba.biblio_id='.$_biblio_d['biblio_id']);
            while ($_auth_d = $_biblio_authors_q->fetch_assoc()) {
                $_buffer .= '<name type="'.$sysconf['authority_type'][$_auth_d['authority_type']].'" authority="'.$_auth_d['auth_list'].'">'."\n"
                  .'<namePart>'.$_auth_d['author_name'].'</namePart>'."\n"
                  .'<role><roleTerm type="text">'.$sysconf['authority_level'][$_auth_d['level']].'</roleTerm></role>'."\n"
                .'</name>'."\n";
            }
            $_buffer .= '<typeOfResource manuscript="yes" collection="yes">mixed material</typeOfResource>'."\n";
            $_biblio_authors_q->free_result();
            $_buffer .= '</mods>'."\n";
        }
        $_buffer .= '</modsCollection>';

        // free resultset memory
        $this->resultset->free_result();

        return $_buffer;
    }


    /**
     * Method to get list of document IDs of result
     *
     * @return  mixed
     */
    public function getDocumentIds()
    {
        $_temp_resultset = $this->resultset;
        while ($_biblio_d = $_temp_resultset->fetch_assoc()) {
            $this->biblio_ids[] = $_biblio_d['biblio_id'];
        }
        unset($_temp_resultset);
        return $this->biblio_ids;
    }
}
?>
