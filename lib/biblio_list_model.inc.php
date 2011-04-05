<?php
/**
 * biblio_list model
 * Template/Abstract Class for bibliographic records listing
 *
 * Copyright (C) 2010 Arie Nugraha (dicarve@yahoo.com)
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

abstract class biblio_list_model
{
    /* Public properties */
    public $num_rows = 0;
    public $num2show = 10;
    public $xml_detail = true;
    public $xml_result = true;
    public $only_promoted = false;
    public $show_labels = true;
    public $stop_words = array('a', 'an', 'of', 'the', 'to', 'so', 'as', 'be');
    public $query_time = 0;
    public $disable_item_data = false;
    public $enable_mark = true;
    public $query_error;
    public $current_page = 1;
    public $item_availability_message = 'none copy available';
    /* Protected properties */
    protected $obj_db = false;
    protected $resultset = false;
    protected $subquery = array();
    protected $biblio_ids = array();
    protected $emulate_short_word_search = false;
    protected $queries_word_num_allowed = 20;
    protected $criteria = array();
    protected $label_cache = array();
    protected $custom_fields = array();
    protected $enable_custom_frontpage = false;
    protected $orig_query;
    protected $searchable_fields = array('title', 'author', 'subject', 'isbn',
	'gmd', 'colltype', 'class', 'callnumber', 'notes',
	'publisher', 'publish_year', 'itemcode', 'location');
    protected $field_join_type = array();

    /**
     * Class Constructor
     *
     * @param   object  $obj_db
     * @param   integer	$int_num_show
     */
    public function __construct($obj_db, $int_num_show = 20) {
	$this->obj_db = $obj_db;
	$this->num2show = $int_num_show;
    }


    /**
     * Method to set search criteria
     * Extend this method
     *
     * @param   string  $str_criteria
     * @return  void
     */
    public function setSQLcriteria($str_criteria) { }


    /**
     * Method to compile SQL statement based on criteria
     *
     * @param   string  $str_criteria
     * @return  void
     */
    protected function compileSQL() { }


    /**
     * Method to get string of authors data of bibliographic record
     *
     * @param   integer	$int_biblio_id
     * @return  string
     */
    public static function getAuthors($obj_db, $int_biblio_id) {
	$_authors = '';
	$_sql_str = 'SELECT a.author_name, a.author_id FROM biblio_author AS ba
            LEFT JOIN biblio AS b ON ba.biblio_id=b.biblio_id
            LEFT JOIN mst_author AS a ON ba.author_id=a.author_id WHERE ba.biblio_id='.$int_biblio_id;
        // query the author
        $_author_q = $obj_db->query($_sql_str);
        // concat author data
        while ($_author_d = $_author_q->fetch_row()) {
            $counter = count ($_author_d);
            $_authors .= $_author_d[0];
            $_authors .= ' - ';
        }
	return $_authors;
    }


    /**
     * Method to get list of document IDs of result
     *
     * @return  mixed
     */
    public function getDocumentIds()
    {
        $_temp_resultset = $this->resultset;
        while ($_biblio_d = $_temp_resultset->fetch_assoc()) { $this->biblio_ids[] = $_biblio_d['biblio_id']; }
        unset($_temp_resultset);
        return $this->biblio_ids;
    }


    /**
     * Method to print out document records
     *
     * @param   object  $obj_db
     * @param   integer $int_num2show
     * @param   boolean $bool_return_output
     * @return  string
     */
    public function getDocumentList($bool_return_output = true)
    {
	global $sysconf;
	$_sql_str = $this->compileSQL();
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
            return '<div style="border: 1px dotted #f00; color: #f00; padding: 5px; margin: 5px;">Query error : '.$this->query_error.'</div>';
        }
        while ($_biblio_d = $this->resultset->fetch_assoc()) {
            $_biblio_d['title'] = '<a href="'.$sysconf['baseurl'].'index.php?p=show_detail&id='.$_biblio_d['biblio_id'].'" class="titleField" title="'.__('Record Detail').'">'.$_biblio_d['title'].'</a>';
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
                #$cache_images_loc = 'images/cache/'.$_biblio_d['image'];
                if ($sysconf['tg']['type'] == 'phpthumb') {
                    $_image_cover = 'style="background-image: url(./lib/phpthumb/phpThumb.php?src=../../'.$images_loc.'&w=42); background-repeat: no-repeat;"';
                } elseif ($sysconf['tg']['type'] == 'minigalnano') {
                    $_image_cover = 'style="background-image: url(./lib/minigalnano/createthumb.php?filename=../../'.$images_loc.'&width=42); background-repeat: no-repeat;"';
                } else {
                    $_image_cover = 'style="background-image: url(./lib/phpthumb/phpThumb.php?src=../../'.$images_loc.'&w=42); background-repeat: no-repeat;"';
                }
            }

            $_alt_list = ($_i%2 == 0)?'alterList':'alterList2';
            $_buffer .= '<div class="item '.$_alt_list.'" '.$_image_cover.'>'.$_biblio_d['title'].'<br />';
            // concat author data
            $_authors = isset($_biblio_d['author'])?$_biblio_d['author']:self::getAuthors($this->obj_db, $_biblio_d['biblio_id']);
            if ($_authors) {
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
                        } else if ($_field == 'availability' && !$this->disable_item_data) {
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
                                $_buffer .= '<div class="customField availabilityField"><b>'.$_field_opts[1].'</b> : <strong style="color: #f00;">'.$this->item_availability_message.'</strong></div>';
                            } else {
                                $this->item_availability_message = $_total_avail.' copies available for loan';
                                $_buffer .= '<div class="customField availabilityField"><b>'.$_field_opts[1].'</b> : '.$this->item_availability_message.'</div>';
                            }
                        } else if ($_field == 'node_id' && $this->disable_item_data) {
			    $_buffer .= '<div class="customField locationField"><b>'.$_field_opts[1].'</b> : '.$sysconf['node'][$_biblio_d['node_id']]['name'].'</div>';
			}
                    }
                }
            }

	    // checkbox for marking collection
	    $_check_mark = (utility::isMemberLogin() && $this->enable_mark)?' <input type="checkbox" id="biblioCheck'.$_i.'" name="biblio[]" class="biblioCheck" value="'.$_biblio_d['biblio_id'].'" /> <label for="biblioCheck'.$_i.'">'.__('mark this').'</label>':'';
            $_buffer .= '<div class="subItem">'.$_biblio_d['detail_button'].' '.$_biblio_d['xml_button'].$_check_mark.'</div>';
            $_buffer .= "</div>\n";
            $_i++;
        }

        // free resultset memory
        $this->resultset->free_result();

        // paging
        if (($this->num_rows > $this->num2show)) {
            $_paging = '<div class="biblioPaging">'.simbio_paging::paging($this->num_rows, $this->num2show, 5).'</div>';
        } else {
            $_paging = '';
        }

		$_biblio_list = '';
		$_is_member_logged_in = utility::isMemberLogin() && $this->enable_mark;
		if ($_paging) {
			$_biblio_list .= $_paging;
			$_biblio_list .= '<hr width="98%" size="1" />';
		}
		if ($_is_member_logged_in) {
			$_submit = '<div class="biblioMarkFormAction"><input type="submit" class="button markBiblio" name="markBiblio" value="'.__('Put marked selection into basket').'" /></div>';
			$_biblio_list .= '<form class="biblioMarkForm" method="post" action="index.php?p=member#biblioBasket">';
			$_biblio_list .= $_submit;
		}
		$_biblio_list .= $_buffer;
		if ($_is_member_logged_in) {
			$_biblio_list .= $_submit;
			$_biblio_list .= '</form>';
		}
		if ($_paging) {
			$_biblio_list .= '<hr width="98%" size="1" />';
			$_biblio_list .= $_paging;
		}

        return $_biblio_list;
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
        $_buffer = '<modsCollection xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.loc.gov/mods/v3" xmlns:slims="http://senayan.diknas.go.id" xsi:schemaLocation="http://www.loc.gov/mods/v3 http://www.loc.gov/standards/mods/v3/mods-3-3.xsd">'."\n";
        $_buffer .= '<slims:resultInfo>'."\n";
        $_buffer .= '<slims:modsResultNum>'.$this->num_rows.'</slims:modsResultNum>'."\n";
        $_buffer .= '<slims:modsResultPage>'.$this->current_page.'</slims:modsResultPage>'."\n";
        $_buffer .= '<slims:modsResultShowed>'.$this->num2show.'</slims:modsResultShowed>'."\n";
        $_buffer .= '</slims:resultInfo>'."\n";
        while ($_biblio_d = $this->resultset->fetch_assoc()) {
            $_buffer .= '<mods version="3.3" ID="'.$_biblio_d['biblio_id'].'">'."\n";
            // parse title
            $_title_sub = '';
            if (stripos($_biblio_d['title'], ':') !== false) {
                $_title_main = trim(substr_replace($_biblio_d['title'], '', stripos($_biblio_d['title'], ':')+1));
                $_title_sub = trim(substr_replace($_biblio_d['title'], '', 0, stripos($_biblio_d['title'], ':')+1));
            } else {
                $_title_main = trim($_biblio_d['title']);
            }

            $_buffer .= '<titleInfo>'."\n".'<title>'.htmlentities($_title_main).'</title>'."\n";
            if ($_title_sub) {
                $_buffer .= '<subTitle>'.htmlentities($_title_sub).'</subTitle>'."\n";
            }
            $_buffer .= '</titleInfo>'."\n";

            // get the authors data
            $_biblio_authors_q = $this->obj_db->query('SELECT a.*,ba.level FROM mst_author AS a'
                .' LEFT JOIN biblio_author AS ba ON a.author_id=ba.author_id WHERE ba.biblio_id='.$_biblio_d['biblio_id']);
            while ($_auth_d = $_biblio_authors_q->fetch_assoc()) {
                // some rules to set name type in mods standard
                if ($sysconf['authority_type'][$_auth_d['authority_type']] == 'Personal Name') {
                    $sysconf['authority_type'][$_auth_d['authority_type']] = 'personal';
                } elseif ($sysconf['authority_type'][$_auth_d['authority_type']] == 'Organizational Body') {
                    $sysconf['authority_type'][$_auth_d['authority_type']] = 'corporate';
                } elseif ($sysconf['authority_type'][$_auth_d['authority_type']] == 'Conference') {
                    $sysconf['authority_type'][$_auth_d['authority_type']] = 'conference';
                } else {
                    $sysconf['authority_type'][$_auth_d['authority_type']] = 'personal';
                }
                $_buffer .= '<name type="'.$sysconf['authority_type'][$_auth_d['authority_type']].'" authority="'.$_auth_d['auth_list'].'">'."\n"
                  .'<namePart>'.$_auth_d['author_name'].'</namePart>'."\n"
                  .'<role><roleTerm type="text">'.$sysconf['authority_level'][$_auth_d['level']].'</roleTerm></role>'."\n"
                .'</name>'."\n";
            }
            $_buffer .= '<typeOfResource manuscript="yes" collection="yes">mixed material</typeOfResource>'."\n";
            $_biblio_authors_q->free_result();

			// ISBN
			$_buffer .= '<identifier type="isbn">'.str_replace(array('-', ' '), '', $_biblio_d['isbn_issn']).'</identifier>'."\n";

			// imprint/publication data
			$_buffer .= '<originInfo>'."\n";
			$_buffer .= '<place><placeTerm type="text">'.htmlentities($_biblio_d['publish_place']).'</placeTerm></place>'."\n"
			  .'<publisher>'.htmlentities($_biblio_d['publisher']).'</publisher>'."\n"
			  .'<dateIssued>'.htmlentities($_biblio_d['publish_year']).'</dateIssued>'."\n";
			$_buffer .= '</originInfo>'."\n";

			// doc images
            $_image = '';
            if (!empty($_biblio_d['image'])) {
                $_image = urlencode($_biblio_d['image']);
				$_buffer .= '<slims:image>'.$_image.'</slims:image>'."\n";
            }

            $_buffer .= '</mods>'."\n";
        }
        $_buffer .= '</modsCollection>';

        // free resultset memory
        $this->resultset->free_result();

        return $_buffer;
    }
}
?>
