<?php
/**
 * biblio_list class
 * Class for generating list of bibliographic records
 *
 * Copyright (C) 2009 Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
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
    private $obj_db = false;
    private $resultset = false;
    private $num2show = 10;
    private $subquery = array();
    private $criterias = array();
    private $biblio_ids = array();
    public $num_rows = 0;
    public $xml_detail = true;
    public $xml_result = true;
    public $only_promoted = false;
    public $show_labels = true;
    public $stop_words = array('a', 'an', 'of', 'the', 'to', 'so', 'as', 'be');

    protected $subquery_string = '';
    protected $label_cache = array();
    protected $custom_fields = array();
    protected $enable_custom_frontpage = false;
    protected $orig_query;
    protected $searchable_fields = array('title', 'author', 'subject', 'isbn', 'publisher', 'gmd', 'notes', 'colltype', 'location');
    protected $field_join_type = array('title' => 'OR', 'author' => 'OR', 'subject' => 'OR');

    /**
     * Search query parser
     *
     * @param   string  $str_criteria
     * @return  array
     */
    public function queryParser($str_criteria)
    {
        // add extra space
        $str_criteria = trim($str_criteria).' ';
        $this->orig_query = $str_criteria;
        // convert all spaces to single space
        $str_criteria = preg_replace('@\s{2,}@i', ' ', $str_criteria);
        // clean equal sign operator from whitespace
        $str_criteria = str_replace(' = ', '=', $str_criteria);
        // initialize search query arrays
        $field_search = array();
        $non_field_search = '';
        // get field qualifier data
        $_matches = array();
        preg_match_all('@([\+\-\*]*[a-z0-9_.]+=[^=]+\s)@i', $str_criteria, $_matches);
        // field qualified search query
        foreach ($_matches[1] as $_match_field) {
            foreach ($this->searchable_fields as $_field) {
                if (stripos($_match_field, $_field) !== false) {
                    $field_search[$_field] = trim(str_ireplace($_field.'=', '', $_match_field));
                }
            }
            // remove field qualified data from original query string
            $str_criteria = str_replace($_match_field, '', $str_criteria);
        }
        // non field qualified search query
        $non_field_search = trim($str_criteria);
        return array('field_search' => $field_search, 'search' => $non_field_search);
    }


    /**
     * Boolean's Logic Parser
     *
     * @param   string  $str_query
     * @param   array   $arr_stop_words
     * @return  string
     **/
    public function booleansLogic($str_query, $arr_stop_words = array())
    {
        $_new_q = '';
        // inside quote flag
        $_inside_quote = false;
        // tokenizing
        $_token = strtok(strtolower($str_query), " \n\t");
        while ($_token !== false) {
            if (in_array($_token, $arr_stop_words) AND !$_inside_quote) {
                // do nothing
                $_token = strtok(" \n\t");
                continue;
            }

            // check if we are inside quotes
            if (strpos($_token, '"') === 0) {
                $_inside_quote = true;
            } else if (preg_match('@[a-z0-9._]+=\"@i', $_token)) {
                $_inside_quote = true;
            } else if (strpos($_token, '"') === strlen($_token)-1) {
                $_inside_quote = false;
            }

            if (in_array($_token, $arr_stop_words) AND !$_inside_quote) {
                // do nothing
            } else if ($_token == 'exact' AND !$_inside_quote) {
                $_new_q .= '== ';
            } else if ($_token == 'and' AND !$_inside_quote) {
                $_new_q .= '';
            } else if ($_token == 'or' AND !$_inside_quote) {
                $_new_q .= '*';
            } else if ($_token == 'not' AND !$_inside_quote) {
                $_new_q .= '-';
            } else if (in_array($_token, $arr_stop_words) AND !$_inside_quote) {
                // do nothing
            } else {
                $_new_q .= "$_token ";
            }
            $_token = strtok(" \n\t");
        }
        $_new_q = str_replace(array('-+', '*+', '++'), array('-', '*', '+'), $_new_q);
        return $_new_q;
    }


    /**
     * Method to set search criteria
     *
     * @param   string  $str_criteria
     * @return  void
     */
    public function setSQLcriteria($str_criteria)
    {
        // remove illegal characters
        $str_criteria = str_replace("\\", '', $str_criteria);
        // parse query
        $_parsed_q = $this->queryParser($this->booleansLogic($str_criteria, $this->stop_words));
        // search on title
        if (isset($_parsed_q['field_search']['title'])) {
            $_title_q = $_parsed_q['field_search']['title'];
            // check join type
            switch (substr($_title_q, 0, 1)) {
                case '*' : $this->field_join_type['title'] = 'OR'; break;
                case '-' : $this->field_join_type['title'] = 'NOT'; break;
                default : $this->field_join_type['title'] = 'AND'; break;
            }

            $keywords = '';
            $or_keywords = '';
            $_inside_quote = false;
            $word = '';
            // tokenize string
            $_token = strtok($_title_q, ' ');
            while ($_token !== false) {
                $_quote_pos = strpos($_token, '"');
                // check for quotes
                if ($_quote_pos === 1 OR $_quote_pos === 0) {
                    $_inside_quote = true;
                    $word = '';
                }

                if ($_inside_quote) {
                    if ($_quote_pos === strlen($_token)-1) {
                        $_inside_quote = false;
                        $word .= str_replace('"', '', $_token);
                    } else {
                        $word .= str_replace('"', '', $_token).' ';
                        $_token = strtok(' ');
                        // we continue to the next loop and concatenating words
                        if ($_token !== false) {
                            continue;
                        }
                    }
                } else {
                    $word = $_token;
                }

                // get word length
                $wordlen = strlen($word);
                // for less than 3 characters word append asterix sign
                if ($wordlen < 4) {
                    $word = str_replace(array('*'), '', $word).'*';
                }

                $word = trim($word);
                if (stripos($word, '*') === 0) {
                    $or_keywords .= str_replace('*', '', $word).' ';
                } else if (stripos($word, '-') === 0) {
                    $keywords .= $word.' ';
                } else {
                    $keywords .= '+'.$word.' ';
                }
                // token again
                $_token = strtok(' ');
            }
            // trim the concatenated keywords
            $keywords = trim($keywords);
            $or_keywords = trim($or_keywords);
            $this->subquery['title'] = "(SELECT DISTINCT biblio_id FROM biblio WHERE MATCH (title, series_title) AGAINST ('$keywords' IN BOOLEAN MODE)";
            if ($or_keywords) {
                $this->subquery['title'] .= " OR MATCH (title, series_title) AGAINST ('$or_keywords' IN BOOLEAN MODE)";
            }
            $this->subquery['title'] .= ")";
        }

        // search on authors
        if (isset($_parsed_q['field_search']['author'])) {
            $_author_q = $_parsed_q['field_search']['author'];
            // check join type
            switch (substr($_author_q, 0, 1)) {
                case '*' : $this->field_join_type['author'] = 'OR'; break;
                case '-' : $this->field_join_type['author'] = 'NOT'; break;
                default : $this->field_join_type['author'] = 'AND'; break;
            }

            $str = '';
            // tokenizing words
            $_token = strtok($_author_q, ' ');
            $_inside_quote = false;
            $word = '';
            // loop
            while ($_token !== false) {
                $_quote_pos = strpos($_token, '"');
                // check for quotes
                if ($_quote_pos === 1 OR $_quote_pos === 0) {
                    $_inside_quote = true;
                    $word = '';
                }

                if ($_inside_quote) {
                    if ($_quote_pos === strlen($_token)-1) {
                        $_inside_quote = false;
                        $word .= str_replace('"', '', $_token);
                    } else {
                        $word .= str_replace('"', '', $_token).' ';
                        $_token = strtok(' ');
                        // we continue to the next loop and concatenating words
                        if ($_token !== false) {
                            continue;
                        }
                    }
                } else {
                    $word = $_token;
                }

                if (strpos($word, '*') === 0) {
                    $word = preg_replace('@^[\+\-\*]@i', '', trim($word));
                    $str .= " OR biblio_id IN (SELECT biblio_id FROM biblio_author AS ba"
                        ." LEFT JOIN mst_author AS a ON ba.author_id=a.author_id"
                        ." WHERE author_name LIKE '%$word%')";
                } else if (strpos($word, '-') === 0) {
                    $word = preg_replace('@^[\+\-\*]@i', '', trim($word));
                    $str .= " AND biblio_id NOT IN (SELECT biblio_id FROM biblio_author AS ba"
                        ." LEFT JOIN mst_author AS a ON ba.author_id=a.author_id"
                        ." WHERE author_name LIKE '%$word%')";
                } else {
                    $word = preg_replace('@^[\+\-\*]@i', '', trim($word));
                    $str .= " AND biblio_id IN (SELECT biblio_id FROM biblio_author AS ba"
                        ." LEFT JOIN mst_author AS a ON ba.author_id=a.author_id"
                        ." WHERE author_name LIKE '%$word%')";
                }
                $_token = strtok(' ');
            }
            // remove the last AND word
            $str = substr_replace($str, '', 0, 4);
            $str = "($str)";
            $this->subquery['author'] = "(SELECT DISTINCT biblio_id FROM biblio AS b WHERE $str)";
        }

        // search on subject
        if (isset($_parsed_q['field_search']['subject'])) {
            $_subject_q = $_parsed_q['field_search']['subject'];
            // check join type
            switch (substr($_subject_q, 0, 1)) {
                case '*' : $this->field_join_type['subject'] = 'OR'; break;
                case '-' : $this->field_join_type['subject'] = 'NOT'; break;
                default : $this->field_join_type['subject'] = 'AND'; break;
            }

            $str = '';
            // tokenizing words
            $_token = strtok($_subject_q, ' ');
            $_inside_quote = false;
            $word = '';
            // loop
            while ($_token !== false) {
                $_quote_pos = strpos($_token, '"');
                // check for quotes
                if ($_quote_pos === 1 OR $_quote_pos === 0) {
                    $_inside_quote = true;
                    $word = '';
                }

                if ($_inside_quote) {
                    if ($_quote_pos === strlen($_token)-1) {
                        $_inside_quote = false;
                        $word .= str_replace('"', '', $_token);
                    } else {
                        $word .= str_replace('"', '', $_token).' ';
                        $_token = strtok(' ');
                        // we continue to the next loop and concatenating words
                        if ($_token !== false) {
                            continue;
                        }
                    }
                } else {
                    $word = $_token;
                }

                if (strpos($word, '*') === 0) {
                    $word = preg_replace('@^[\+\-\*]@i', '', trim($word));
                    $str .= " OR biblio_id IN (SELECT biblio_id FROM biblio_topic AS bt"
                        ." LEFT JOIN mst_topic AS t ON bt.topic_id=t.topic_id"
                        ." WHERE topic LIKE '%$word%')";
                } else if (strpos($word, '-') === 0) {
                    $word = preg_replace('@^[\+\-\*]@i', '', trim($word));
                    $str .= " AND biblio_id NOT IN (SELECT biblio_id FROM biblio_topic AS bt"
                        ." LEFT JOIN mst_topic AS t ON bt.topic_id=t.topic_id"
                        ." WHERE topic LIKE '%$word%')";
                } else {
                    $word = preg_replace('@^[\+\-\*]@i', '', trim($word));
                    $str .= " AND biblio_id IN (SELECT biblio_id FROM biblio_topic AS bt"
                        ." LEFT JOIN mst_topic AS t ON bt.topic_id=t.topic_id"
                        ." WHERE topic LIKE '%$word%')";
                }
                $_token = strtok(' ');
            }
            // remove the boolean operator
            $str = substr_replace($str, '', 0, 4);
            $str = "($str)";
            $this->subquery['subject'] = "(SELECT DISTINCT biblio_id FROM biblio_topic AS b WHERE $str)";
        }

        // other field search
        foreach ($this->searchable_fields as $_search_field) {
            if (isset($_parsed_q['field_search'][$_search_field])) {
                $_criteria = $_parsed_q['field_search'][$_search_field];
                // check join type
                switch (substr($_criteria, 0, 1)) {
                    case '*' : $_boolean = 'OR'; break;
                    case '-' : $_boolean = 'NOT'; break;
                    default : $_boolean = 'AND'; break;
                }
                // remove all boolean symbols
                $_parsed_q['field_search'][$_search_field] = trim(preg_replace('@(^[\+\*\-])|[\+\*]@i', '', $_parsed_q['field_search'][$_search_field]));
                switch ($_search_field) {
                    case 'location' :
                        $_subquery = 'SELECT location_id FROM mst_location WHERE location_name=\''.$_parsed_q['field_search']['location'].'\'';
                        if ($_boolean == 'NOT') {
                            $this->criterias['location'] = " AND i.location_id NOT IN ($_subquery)";
                        } else { $this->criterias['location'] = " $_boolean i.location_id IN ($_subquery)"; }
                        break;
                    case 'colltype' :
                        $_subquery = 'SELECT coll_type_id FROM mst_coll_type WHERE coll_type_name=\''.$_parsed_q['field_search']['colltype'].'\'';
                        if ($_boolean == 'NOT') {
                            $this->criterias['colltype'] = " AND i.coll_type_id NOT IN ($_subquery)";
                        } else { $this->criterias['location'] = " $_boolean i.coll_type_id IN ($_subquery)"; }
                        break;
                    case 'isbn' :
                        if ($_boolean == 'NOT') {
                            $this->criterias['isbn'] = ' AND b.isbn_issn!=\''.$_parsed_q['field_search']['isbn'].'\'';
                        } else { $this->criterias['isbn'] = ' '.$_boolean.' b.isbn_issn=\''.$_parsed_q['field_search']['isbn'].'\''; }
                        break;
                    case 'publisher' :
                        $_subquery = 'SELECT publisher_id FROM mst_publisher WHERE publisher_name=\''.$_parsed_q['field_search']['publisher'].'\'';
                        if ($_boolean == 'NOT') {
                            $this->criterias['publisher'] = " AND b.publisher_id NOT IN ($_subquery)";
                        } else { $this->criterias['publisher'] = " $_boolean b.publisher_id IN ($_subquery)"; }
                        break;
                    case 'gmd' :
                        $_subquery = 'SELECT gmd_id FROM mst_gmd WHERE gmd_name=\''.$_parsed_q['field_search']['gmd'].'\'';
                        if ($_boolean == 'NOT') {
                            $this->criterias['gmd'] = " AND b.gmd_id NOT IN ($_subquery)";
                        } else { $this->criterias['gmd'] = " $_boolean b.gmd_id IN ($_subquery)"; }
                        break;
                    case 'notes' :
                        if ($_boolean == 'NOT') {
                            $this->criterias['notes'] = " AND NOT (MATCH (notes) AGAINST ('".$_parsed_q['field_search']['notes']."', IN BOOLEAN MODE))";
                        } else { $this->criterias['notes'] = " AND (MATCH (notes) AGAINST ('".$_parsed_q['field_search']['notes']."', IN BOOLEAN MODE))"; }
                        break;
                }
            }
        }

        // join all subquery string to complete sql criteria string
        if ($this->subquery) {
            foreach ($this->subquery as $_field => $_subquery) {
                if (isset($this->field_join_type[$_field])) {
                    switch ($this->field_join_type[$_field]) {
                        case 'OR' : $this->subquery_string .= " OR b.biblio_id IN ($_subquery)"; break;
                        case 'NOT' : $this->subquery_string .= " AND b.biblio_id NOT IN ($_subquery)"; break;
                        default : $this->subquery_string .= " AND b.biblio_id IN ($_subquery)"; break;
                    }
                }
            }
            $this->subquery_string = preg_replace('@^\s*(AND|OR)\s*@i', '', $this->subquery_string);
        }

        return array('subquery' => $this->subquery_string, 'biblio_field' => $this->criterias);
    }


    /**
     * Method to print out document records
     *
     * @param   object  $obj_db
     * @param   integer $int_num2show
     * @param   boolean $bool_return_output
     * @return  string
     */
    public function getDocumentList($obj_db, $int_num2show = 10, $bool_return_output = true)
    {
        global $sysconf;

        $this->obj_db = $obj_db;
        $this->num2show = $int_num2show;
        // get page number from http get var
        if (!isset($_GET['page']) OR $_GET['page'] < 1){
            $_page = 1;
        } else{
            $_page = (integer)$_GET['page'];
        }

        // count the row offset
        if ($_page <= 1) {
            $_offset = 0;
        } else {
            $_offset = ($_page*$this->num2show) - $this->num2show;
        }

        // init sql string
        $_sql_str = 'SELECT SQL_CALC_FOUND_ROWS b.biblio_id, b.title, b.image, b.labels';
        $_add_sql_str = '';

        // location
        if (isset($this->criterias['location']) OR isset($this->criterias['colltype'])) {
            $_add_sql_str .= ' LEFT JOIN item AS i ON b.biblio_id=i.biblio_id ';
        }

        $_add_sql_str .= ' WHERE opac_hide=0 ';
        // promoted flag
        if ($this->only_promoted) { $_add_sql_str .= ' AND promoted=1'; }
        // main search criteria
        if ($this->subquery_string) {
            $_add_sql_str .= ' AND ('.$this->subquery_string.') ';
        }
        // other field criteria
        if ($this->criterias) {
            foreach ($this->criterias as $_criteria) {
                $_add_sql_str .= ' '.$_criteria;
            }
        }

        // checking custom frontpage fields file
        $custom_frontpage_record_file = SENAYAN_BASE_DIR.$sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/custom_frontpage_record.inc.php';
        if (file_exists($custom_frontpage_record_file)) {
            include $custom_frontpage_record_file;
            $this->enable_custom_frontpage = true;
            $this->custom_fields = $custom_fields;
            foreach ($this->custom_fields as $_field => $_field_opts) {
                if ($_field_opts[0] == 1) {
                    $_sql_str .= ", b.$_field";
                }
            }
        }

        $_sql_str .= ' FROM biblio AS b '.$_add_sql_str.' ORDER BY b.last_update DESC LIMIT '.$_offset.', '.$this->num2show;

        // for debugging purpose only
        // echo $_sql_str;
        // query
        $this->resultset = $obj_db->query($_sql_str);
        // get total number of rows from query
        $_total_q = $obj_db->query('SELECT FOUND_ROWS()');
        if ($obj_db->error) {
            return '<div style="padding: 5px; border: 1px dotted #FF0000; color: #FF0000;">Error on query bibliographic database. Please check your database</div>';
        }
        $_total_d = $_total_q->fetch_row();
        $this->num_rows = $_total_d[0];
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
        while ($_biblio_d = $this->resultset->fetch_assoc()) {
            $_biblio_d['title'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&id='.$_biblio_d['biblio_id'].'" title="'.(defined('lang_opac_rec_detail')?lang_opac_rec_detail:'View Record Detail').'">'.$_biblio_d['title'].'</a>';
            // label
            if ($this->show_labels AND !empty($_biblio_d['labels'])) {
                $arr_labels = explode(' ', $_biblio_d['labels']);
                foreach ($arr_labels as $label) {
                    if (!isset($this->label_cache[$label]['name'])) {
                        $_label_q = $this->obj_db->query('SELECT label_name, label_desc, label_image FROM mst_label AS lb
                            WHERE lb.label_name=\''.$label.'\'');
                        $_label_d = $_label_q->fetch_row();
                        $this->label_cache[$label] = array('name' => $_label_d[0], 'desc' => $_label_d[1], 'image' => $_label_d[2]);
                    }
                    $_biblio_d['title'] .= ' <img src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/labels/'.$this->label_cache[$label]['image'].'" title="'.$this->label_cache[$label]['desc'].'" align="middle" class="labels" />';
                }
            }
            // button
            $_biblio_d['detail_button'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&id='.$_biblio_d['biblio_id'].'" class="detailLink" title="'.(defined('lang_opac_rec_detail')?lang_opac_rec_detail:'View Record Detail').'">Record Detail</a>';
            if ($this->xml_detail) {
                $_biblio_d['xml_button'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&inXML=true&id='.$_biblio_d['biblio_id'].'" class="xmlDetailLink" title="View Detail in XML Format" target="_blank">XML Detail</a>';
            } else {
                $_biblio_d['xml_button'] = '';
            }

            // cover images var
            $_image_cover = '';
            if (!empty($_biblio_d['image'])) {
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
                $_buffer .= '<div class="subItem"><span class="author">'.(defined('lang_mod_biblio_field_authors')?lang_mod_biblio_field_authors:'Authors').'</span> : '.$_authors.'</div>';
            }

            # checking custom file
            if ($this->enable_custom_frontpage AND $this->custom_fields) {
                foreach ($this->custom_fields as $_field => $_field_opts) {
                    if ($_field_opts[0] == 1) {
                        if ($_field == 'edition') {
                            $_buffer .= '<div><strong>'.$_field_opts[1].'</strong> : '.$_biblio_d['edition'].'</div>';
                        } else if ($_field == 'isbn_issn') {
                            $_buffer .= '<div><strong>'.$_field_opts[1].'</strong> : '.$_biblio_d['isbn_issn'].'</div>';
                        } else if ($_field == 'collation') {
                            $_buffer .= '<div><strong>'.$_field_opts[1].'</strong> : '.$_biblio_d['collation'].'</div>';
                        } else if ($_field == 'series_title') {
                            $_buffer .= '<div><strong>'.$_field_opts[1].'</strong> : '.$_biblio_d['series_title'].'</div>';
                        } else if ($_field == 'call_number') {
                            $_buffer .= '<div><strong>'.$_field_opts[1].'</strong> : '.$_biblio_d['call_number'].'</div>';
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
