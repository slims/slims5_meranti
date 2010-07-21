<?php
/**
 * biblio_list class
 * Class for generating list of bibliographic records from SPHINX index
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


class biblio_list extends biblio_list_model
{
    protected $searchable_fields = array('title', 'author', 'subject', 'isbn',
		'publisher', 'gmd', 'notes', 'colltype', 'publishyear',
		'location', 'itemcode', 'callnumber', 'itemcallnumber', 'notes');
    protected $field_join_type = array('title' => 'OR', 'author' => 'OR', 'subject' => 'OR');
	private $sphinx = null;
	private $options = array('host' => '127.0.0.1', 'port' => 9312, 'index' => 'slims',
		'mode' => null, 'timeout' => 0, 'filter' => '@last_update desc',
		'filtervals' => array(), 'groupby' => null, 'groupsort' => null,
		'sortby' => null, 'sortexpr' => null, 'distinct' => 'biblio_id',
		'select' => null, 'limit' => 20, 'max_limit' => 500000,
		'ranker' => null);

    /**
     * Class Constructor
     *
     * @param   object  $obj_db
     * @param   integer	$int_num_show
     */
    public function __construct($obj_db, $int_num_show)
    {
        parent::__construct($obj_db, $int_num_show);
		if (!class_exists('SphinxClient')) {
			throw new Exception('SPHINX API Library is not installed yet!');
		} else {
			$this->sphinx = new SphinxClient();
			// defaults
			$this->options['mode'] = SPH_MATCH_EXTENDED2;
			$this->options['ranker'] = SPH_RANK_PROXIMITY_BM25;
		}
    }


    /**
     * Compile SQL
     *
     * @return  string
     */
    public function compileSQL()
    {
		// search string
		$_query_str = isset($this->criteria['sql_criteria'])?trim($this->criteria['sql_criteria']):'';
		if (!$_query_str) {
			return '';
		}

        // get page number from http get var
        if (!isset($_GET['page']) OR $_GET['page'] < 1){ $_page = 1; } else {
            $_page = (integer)$_GET['page'];
        }
        $this->current_page = $_page;

        // count the row offset
        if ($this->current_page <= 1) { $_offset = 0; } else {
            $_offset = ($this->current_page*$this->num2show) - $this->num2show;
        }

		// set options
		$this->sphinx->SetServer ( $this->options['host'], $this->options['port'] );
		$this->sphinx->SetConnectTimeout ( $this->options['timeout'] );
		$this->sphinx->SetArrayResult ( true );
		$this->sphinx->SetWeights ( array ( 100, 1 ) );
		$this->sphinx->SetMatchMode ( $this->options['mode'] );
		if (count($this->options['filtervals'])) { $this->sphinx->SetFilter ( $this->options['filter'], $this->options['filtervals'] ); }
		if ($this->options['groupby']) { $this->sphinx->SetGroupBy ( $this->options['groupby'], SPH_GROUPBY_ATTR, $this->options['groupsort'] ); }
		if ($this->options['sortby']) {
			$this->sphinx->SetSortMode ( SPH_SORT_EXTENDED, $this->options['sortby'] );
			$this->sphinx->SetSortMode ( SPH_SORT_EXPR, $this->options['sortexpr'] );
		}
		$this->sphinx->SetGroupDistinct ( $this->options['distinct'] );
		if ($this->options['select']) { $this->sphinx->SetSelect ( $this->options['select'] ); }
		$this->sphinx->SetLimits ( $_offset, $this->num2show?$this->num2show:$this->options['limit'], $this->options['max_limit'] );
		$this->sphinx->SetRankingMode ( $this->options['ranker'] );

		// ivoke sphinx query
		$_search_result = $this->sphinx->Query( $_query_str, $this->options['index'] );
		// echo '<pre>'; $_search_result; echo '</pre>'; die();
		if ($_search_result === false) {
			$this->query_error = $this->sphinx->GetLastError();
			return;
		}

		$this->num_rows = $_search_result['total_found'];
		$this->query_time = $_search_result['time'];

		if (isset($_search_result['matches']) && is_array($_search_result['matches'])) {
			$_matched_ids = '(';
			foreach ($_search_result['matches'] as $_match) {
				$_matched_ids .= $_match['id'].',';
			}
			// remove last comma
			$_matched_ids = substr_replace($_matched_ids, '', -1);
			$_matched_ids .= ')';

			$_sql_str = "SELECT index.biblio_id, index.title,
				index.author, index.topic, index.image,
				index.isbn_issn, index.labels FROM `search_biblio` AS `index` WHERE biblio_id IN $_matched_ids";

			return $_sql_str;
		} else {
			return false;
		}
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
		$_sql_str = $this->compileSQL();
		if ($_sql_str === false) {
			$this->resultset = $this->obj_db->query("SELECT index.biblio_id, index.title,
				index.author, index.topic, index.image,
				index.isbn_issn, index.labels FROM `search_biblio` AS `index` WHERE biblio_id<1");
		} else if ($_sql_str == '') {
			$this->resultset = $this->obj_db->query("SELECT index.biblio_id, index.title,
				index.author, index.topic, index.image,
				index.isbn_issn, index.labels FROM `search_biblio` AS `index` WHERE biblio_id IS NOT NULL");
		} else {
			// execute query
			$this->resultset = $this->obj_db->query($_sql_str);
			if ($this->obj_db->error) {
				$this->query_error = $this->obj_db->error;
			}
			if ($bool_return_output) {
				// return the html result
				return $this->makeOutput();
			}
		}
    }


	/**
	 * Set sphinx search option
	 *
	 * @param	array  $arr_options
	 * @return	void
	 */
	public function setOptions($arr_options)
	{
		$this->options = $arr_options;
	}


    /**
     * Method to set search criteria
     *
     * @param   string  $str_criteria
     * @return  void
     */
    public function setSQLcriteria($str_criteria)
    {
        if (!$str_criteria)
            return null;
        // defaults
        $_sql_criteria = '';
        $_searched_fields = array();
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
		// echo '<pre>'; var_dump($_queries); echo '</pre>';
        foreach ($_queries as $_num => $_query) {
            // field
            $_field = $_query['f'];
            //  break the loop if we meet `cql_end` field
            if ($_field == 'cql_end') { break; }
			// if field is boolean
			if ($_field == 'boolean') {
				if ($_query['b'] == '*') { $_sql_criteria .= ' | '; } else { $_sql_criteria .= ' & '; }
				continue;
			} else {
				if ($_query['b'] == '*') { $_b = ''; } else { $_b = $_query['b']; }
				$_q = @$this->obj_db->escape_string($_query['q']);
				$_q = isset($_query['is_phrase'])?'"'.$_q.'"':$_q;
				$_boolean = '';
			}
            // for debugging purpose only
            // echo "<p>$_num. $_field -> $_boolean -> $_sql_criteria</p><p>&nbsp;</p>";

			// check fields
            switch ($_field) {
                case 'author' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @author $_q";
                    break;
                case 'topic' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @topic $_q";
                    break;
                case 'location' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @location $_q";
                    break;
                case 'colltype' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @collection_types $_q";
                    break;
                case 'itemcode' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @items $_q";
                    break;
                case 'callnumber' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @call_number $_q";
                    break;
                case 'itemcallnumber' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @item_call_number $_q";
                    break;
                case 'class' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @classification $_q";
                    break;
                case 'isbn' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @isbn_issn $_q";
                    break;
                case 'publisher' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @publisher $_q";
                    break;
                case 'publishyear' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @publish_year $_q";
                    break;
                case 'gmd' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @gmd $_q";
                    break;
                case 'notes' :
					$_q = $_b.$_q;
					$_sql_criteria .= " @notes $_q";
                    break;
                default :
					$_q = $_b.$_q;
					$_sql_criteria .= " @(title,series) $_q";
                    break;
            }
        }

        $this->criteria = array('sql_criteria' => $_sql_criteria, 'searched_fields' => $_searched_fields);
        return $this->criteria;
    }
}
?>
