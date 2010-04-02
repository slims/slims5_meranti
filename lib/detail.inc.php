<?php
/**
 * detail class
 * Class for document/record detail
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 * Some security patches by Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

require 'content_list.inc.php';

class detail extends content_list
{
    private $obj_db = false;
    private $record_detail = array();
    private $detail_id = 0;
    private $error = false;
    private $output_format = 'html';
    protected $detail_prefix = '';
    protected $detail_suffix = '';
    public $record_title;
    public $metadata;

    /**
     * Class Constructor
     *
     * @param   object  $obj_db
     * @param   integer $int_detail_id
     * @param   str     $str_output_format
     * @return  void
     */
    public function __construct($obj_db, $int_detail_id, $str_output_format = 'html')
    {
        if (!in_array($str_output_format, array('html', 'xml', 'mods'))) {
            $this->output_format = trim($str_output_format);
        } else { $this->output_format = $str_output_format; }

        $this->obj_db = $obj_db;
        $this->detail_id = $int_detail_id;
        $_sql = 'SELECT b.*, l.language_name, p.publisher_name, pl.place_name AS \'publish_place\', gmd.gmd_name, fr.frequency FROM biblio AS b
            LEFT JOIN mst_gmd AS gmd ON b.gmd_id=gmd.gmd_id
            LEFT JOIN mst_language AS l ON b.language_id=l.language_id
            LEFT JOIN mst_publisher AS p ON b.publisher_id=p.publisher_id
            LEFT JOIN mst_place AS pl ON b.publish_place_id=pl.place_id
            LEFT JOIN mst_frequency AS fr ON b.frequency_id=fr.frequency_id
            WHERE biblio_id='.$int_detail_id;
        // for debugging purpose only
        // die($_sql);
        // query the data to database
        $_det_q = $obj_db->query($_sql);
        if ($obj_db->error) {
            $this->error = $obj_db->error;
        } else {
            $this->error = false;
            $this->record_detail = $_det_q->fetch_assoc();
            // free the memory
            $_det_q->free_result();
        }
    }


    /**
     * Method to print out the document detail based on template
     *
     * @return  void
     */
    public function showDetail()
    {
        if ($this->error) {
            return '<div style="padding: 5px; margin: 3px; border: 1px dotted #FF0000; color: #FF0000;">Error Fetching data for record detail. Server return error message: '.$this->error.'</div>';
        } else {
            if ($this->output_format == 'html' AND !empty($this->list_template)) {
                return parent::parseListTemplate($this->htmlOutput());
            } else if ($this->output_format == 'mods') {
                return $this->MODSoutput();
            } else {
                // external output function
                if (function_exists($this->output_format)) {
                    $_ext_func = $this->output_format;
                    return $_ext_func();
                }
                return null;
            }
        }
    }


    /**
     * Record detail output in HTML mode
     * @return  array
     *
     */
    protected function htmlOutput()
    {
        // get global configuration vars array
        global $sysconf;

        foreach ($this->record_detail as $idx => $data) {
            if ($idx == 'notes') {
                $data = nl2br($data);
            } else {
                $data = trim(strip_tags($data));
            }
            $this->record_detail[$idx] = $data;
        }

        // get title and set it to public record_title property
        $this->record_title = $this->record_detail['title'];
        $this->metadata .= '<meta name="Title" content="'.$this->record_title.'" />';
        $this->metadata .= '<meta name="Edition" content="'.$this->record_detail['edition'].'" />';
        $this->metadata .= '<meta name="Call Number" content="'.$this->record_detail['call_number'].'" />';
        $this->metadata .= '<meta name="ISBN/ISSN" content="'.$this->record_detail['isbn_issn'].'" />';
        $this->metadata .= '<meta name="Classification" content="'.$this->record_detail['classification'].'" />';
        $this->metadata .= '<meta name="Series Title" content="'.$this->record_detail['series_title'].'" />';
        $this->metadata .= '<meta name="Media" content="'.$this->record_detail['gmd_name'].'" />';
        $this->metadata .= '<meta name="Language" content="'.$this->record_detail['language_name'].'" />';
        $this->metadata .= '<meta name="Publisher" content="'.$this->record_detail['publisher_name'].'" />';
        $this->metadata .= '<meta name="Publish Year" content="'.$this->record_detail['publish_year'].'" />';
        $this->metadata .= '<meta name="Publish Place" content="'.$this->record_detail['publish_place'].'" />';
        $this->metadata .= '<meta name="Physical Description" content="'.$this->record_detail['collation'].'" />';
        $this->metadata .= '<meta name="Notes" content="'.strip_tags($this->record_detail['notes']).'" />';

        // check image
        if (!empty($this->record_detail['image'])) {
            $this->record_detail['image'] = '<img src="./lib/phpthumb/phpThumb.php?src=../../images/docs/'.urlencode($this->record_detail['image']).'&w=200" border="0" />';
        } else {
            $this->record_detail['image'] = '<img src="./'.$sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/image.png" border="0" />';
        }

        // get the authors data
        $_biblio_authors_q = $this->obj_db->query('SELECT author_name FROM mst_author AS a'
            .' LEFT JOIN biblio_author AS ba ON a.author_id=ba.author_id WHERE ba.biblio_id='.$this->detail_id);
        $authors = '';
        // authors for metadata
        $this->metadata .= '<meta name="Authors" content="';
        while ($data = $_biblio_authors_q->fetch_row()) {
            $authors .= '<a href="?author='.urlencode('"'.$data[0].'"').'&search=Search" title="'.__('Click to view others documents with this author').'">'.$data[0]."</a><br />";
            $this->metadata .= $data[0].'; ';
        }
        $this->metadata .= '" />';
        $this->record_detail['authors'] = $authors;
        // free memory
        $_biblio_authors_q->free_result();

        // get the topics data
        $_biblio_topics_q = $this->obj_db->query('SELECT topic FROM mst_topic AS a
            LEFT JOIN biblio_topic AS ba ON a.topic_id=ba.topic_id WHERE ba.biblio_id='.$this->detail_id);
        $topics = '';
        $this->metadata .= '<meta name="topics" content="';
        while ($data = $_biblio_topics_q->fetch_row()) {
            $topics .= '<a href="?subject='.urlencode('"'.$data[0].'"').'&search=Search" title="'.__('Click to view others documents with this subject').'">'.$data[0]."</a><br />";
            $this->metadata .= $data[0].'; ';
        }
        $this->metadata .= '" />';
        $this->record_detail['subjects'] = $topics;
        // free memory
        $_biblio_topics_q->free_result();

        // availability
        $this->record_detail['availability'] = '<div id="itemListLoad">LOADING LIST...</div>';
        $this->record_detail['availability'] .= '<script type="text/javascript">new Ajax.Updater(\'itemListLoad\', \''.SENAYAN_WEB_ROOT_DIR.'lib/contents/item_list.php\', {method: \'post\', parameters: \'id='.$this->detail_id.'&ajaxsec_user='.$sysconf['ajaxsec_user'].'&ajaxsec_passwd='.$sysconf['ajaxsec_passwd'].'\'});</script>';

        // attachments
        $this->record_detail['file_att'] = '<div id="attachListLoad">LOADING LIST...</div>';
        $this->record_detail['file_att'] .= '<script type="text/javascript">new Ajax.Updater(\'attachListLoad\', \''.SENAYAN_WEB_ROOT_DIR.'lib/contents/attachment_list.php\', {method: \'post\', parameters: \'id='.$this->detail_id.'&ajaxsec_user='.$sysconf['ajaxsec_user'].'&ajaxsec_passwd='.$sysconf['ajaxsec_passwd'].'\'});</script>';

        // get location data
        /*
        $_item_loc_q = $this->obj_db->query('SELECT loc.location_name, COUNT(i.location_id) AS item_num FROM item AS i
            LEFT JOIN mst_location AS loc ON i.location_id=loc.location_id
            WHERE i.biblio_id='.$this->detail_id.' GROUP BY i.location_id');
        if ($_item_loc_q->num_rows < 1) {
            $this->record_detail['location'] = '<strong style="color: red; font-weight: bold;">'.__('There is no item/copy for this title yet').'</strong>';
        } else {
            $this->record_detail['location'] = '';
            while ($_item_loc_d = $_item_loc_q->fetch_row()) {
                $this->record_detail['location'] .= '<strong>'.$_item_loc_d[1].' </strong> '.__('copies at').' <strong>'.$_item_loc_d[0].'</strong><br />'; //mfc
            }
        }
        */
        // show location on UCS
        if (isset($this->record_detail['node_id']) && isset($sysconf['node'][$this->record_detail['node_id']])) {
            $_node = $sysconf['node'][$this->record_detail['node_id']];
            $_node_name = isset($_node['name'])?$_node['name']:'UNKNOWN';
            $this->record_detail['location'] = $_node['baseurl']?'<a href="'.$_node['baseurl'].'" target="_blank">'.$_node_name.'</a>':$_node_name;
            // node detail link
            $node_detail_id = str_ireplace($_node['id'], '', $this->record_detail['orig_biblio_id']);
            $this->record_detail['title'] .= ($_node['baseurl'] && $node_detail_id)?'<div class="nodeDetail"><a href="'.$_node['baseurl'].'/index.php?p=show_detail&id='.$node_detail_id.'" title="'.__('View node catalog data').'" target="_blank">'.__('View node catalog data').'</a></div>':'';
        }

        return $this->record_detail;
    }


    /**
     * Record detail output in MODS (Metadata Object Description Schema) XML mode
     * @return  array
     *
     */
    protected function MODSoutput()
    {
        // get global configuration vars array
        global $sysconf;

        // set prefix and suffix
        $this->detail_prefix = '<modsCollection xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.loc.gov/mods/v3" xsi:schemaLocation="http://www.loc.gov/mods/v3 http://www.loc.gov/standards/mods/v3/mods-3-3.xsd">'."\n";
        $this->detail_suffix = '</modsCollection>';

        $_xml_output = '<mods ID="'.$this->detail_id.'" version="3.3">'."\n";

        // parse title
        $_title_sub = '';
        $_title_statement_resp = '';
        if (stripos($this->record_detail['title'], ':') !== false) {
            $_title_main = trim(substr_replace($this->record_detail['title'], '', stripos($this->record_detail['title'], ':')+1));
            $_title_sub = trim(substr_replace($this->record_detail['title'], '', 0, stripos($this->record_detail['title'], ':')+1));
        } else if (stripos($this->record_detail['title'], '/') !== false) {
            $_title_statement_resp = trim(substr_replace($this->record_detail['title'], '', stripos($this->record_detail['title'], '/')+1));
        } else {
            $_title_main = trim($this->record_detail['title']);
        }

        $_xml_output .= '<titleInfo>'."\n".'<title>'.$_title_main.'</title>'."\n";
        if ($_title_sub) {
            $_xml_output .= '<subTitle>'.$_title_sub.'</subTitle>'."\n";
        }
        $_xml_output .= '</titleInfo>'."\n";

        // personal name
        // get the authors data
        $_biblio_authors_q = $this->obj_db->query('SELECT a.*,ba.level FROM mst_author AS a'
            .' LEFT JOIN biblio_author AS ba ON a.author_id=ba.author_id WHERE ba.biblio_id='.$this->detail_id);
        while ($_auth_d = $_biblio_authors_q->fetch_assoc()) {
            $_xml_output .= '<name type="'.$sysconf['authority_type'][$_auth_d['authority_type']].'" authority="'.$_auth_d['auth_list'].'">'."\n"
              .'<namePart>'.$_auth_d['author_name'].'</namePart>'."\n"
              .'<role><roleTerm type="text">'.$sysconf['authority_level'][$_auth_d['level']].'</roleTerm></role>'."\n"
            .'</name>'."\n";
        }
        $_biblio_authors_q->free_result();

        // resources type
        $_xml_output .= '<typeOfResource manuscript="yes" collection="yes">mixed material</typeOfResource>'."\n";

        // gmd
        $_xml_output .= '<genre authority="marcgt">bibliography</genre>'."\n";

        // imprint/publication data
        $_xml_output .= '<originInfo>'."\n";
        $_xml_output .= '<place><placeTerm type="text">'.$this->record_detail['publish_place'].'</placeTerm></place>'."\n"
          .'<publisher>'.$this->record_detail['publisher_name'].'</publisher>'."\n"
          .'<dateIssued>'.$this->record_detail['publish_year'].'</dateIssued>'."\n";
        if ((integer)$this->record_detail['frequency_id'] > 0) {
            $_xml_output .= '<issuance>continuing</issuance>'."\n";
            $_xml_output .= '<frequency>'.$this->record_detail['frequency'].'</frequency>'."\n";
        } else {
            $_xml_output .= '<issuance>monographic</issuance>'."\n";
        }
        $_xml_output .= '<edition>'.$this->record_detail['edition'].'</edition>'."\n";
        $_xml_output .= '</originInfo>'."\n";

        // language
        $_xml_output .= '<language>'."\n";
        $_xml_output .= '<languageTerm type="code">'.$this->record_detail['language_id'].'</languageTerm>'."\n";
        $_xml_output .= '<languageTerm type="text">'.$this->record_detail['language_name'].'</languageTerm>'."\n";
        $_xml_output .= '</language>'."\n";

        // Physical Description/Collation
        $_xml_output .= '<physicalDescription>'."\n";
        $_xml_output .= '<form authority="gmd">'.$this->record_detail['gmd_name'].'</form>'."\n";
        $_xml_output .= '<extent>'.$this->record_detail['collation'].'</extent>'."\n";
        $_xml_output .= '</physicalDescription>'."\n";

        // Series title
        if ($this->record_detail['series_title']) {
            $_xml_output .= '<relatedItem type="series">'."\n";
            $_xml_output .= '<titleInfo>'."\n";
            $_xml_output .= '<title>'.$this->record_detail['series_title'].'</title>'."\n";
            $_xml_output .= '</titleInfo>'."\n";
            $_xml_output .= '</relatedItem>'."\n";
        }

        // Note
        $_xml_output .= '<note>'.$this->record_detail['notes'].'</note>'."\n";
        if ($_title_statement_resp) {
            $_xml_output .= '<note type="statement of responsibility">'.$_title_statement_resp.'</note>';
        }

        // subject/topic
        $_biblio_topics_q = $this->obj_db->query('SELECT t.topic, t.topic_type, t.auth_list, bt.level FROM mst_topic AS t
            LEFT JOIN biblio_topic AS bt ON t.topic_id=bt.topic_id WHERE bt.biblio_id='.$this->detail_id.' ORDER BY t.auth_list');
        while ($_topic_d = $_biblio_topics_q->fetch_assoc()) {
            $_subject_type = strtolower($sysconf['subject_type'][$_topic_d['topic_type']]);
            $_xml_output .= '<subject authority="'.$_topic_d['auth_list'].'">';
            $_xml_output .= '<'.$_subject_type.'>'.$_topic_d['topic'].'</'.$_subject_type.'>';
            $_xml_output .= '</subject>'."\n";
        }

        // classification
        $_xml_output .= '<classification>'.$this->record_detail['classification'].'</classification>';

        // ISBN/ISSN
        $_xml_output .= '<identifier type="isbn">'.str_replace(array('-', ' '), '', $this->record_detail['isbn_issn']).'</identifier>';

        if (!defined('UCS_BASE_DIR')) {
            // Location and Copies information
            $_xml_output .= '<location>'."\n";
            $_xml_output .= '<physicalLocation>'.$sysconf['library_name'].' '.$sysconf['library_subname'].'</physicalLocation>'."\n";
            $_xml_output .= '<shelfLocator>'.$this->record_detail['call_number'].'</shelfLocator>'."\n";
            $_copy_q = $this->obj_db->query('SELECT i.item_code, i.call_number, stat.item_status_name, loc.location_name, stat.rules, i.site FROM item AS i '
                .'LEFT JOIN mst_item_status AS stat ON i.item_status_id=stat.item_status_id '
                .'LEFT JOIN mst_location AS loc ON i.location_id=loc.location_id '
                .'WHERE i.biblio_id='.$this->detail_id);
            if ($_copy_q->num_rows > 0) {
                $_xml_output .= '<holdingSimple>'."\n";
                while ($_copy_d = $_copy_q->fetch_assoc()) {
                    $_xml_output .= '<copyInformation>'."\n";
                    $_xml_output .= '<numerationAndChronology type="1">'.$_copy_d['item_code'].'</numerationAndChronology>'."\n";
                    $_xml_output .= '<sublocation>'.$_copy_d['location_name'].( $_copy_d['site']?' ('.$_copy_d['site'].')':'' ).'</sublocation>'."\n";
                    $_xml_output .= '<shelfLocator>'.$_copy_d['call_number'].'</shelfLocator>'."\n";
                    $_xml_output .= '</copyInformation>'."\n";
                }
                $_xml_output .= '</holdingSimple>'."\n";
            }
            $_xml_output .= '</location>'."\n";
        }

        // record info
        $_xml_output .= '<recordInfo>'."\n";
        $_xml_output .= '<recordIdentifier>'.$this->detail_id.'</recordIdentifier>'."\n";
        $_xml_output .= '<recordCreationDate encoding="w3cdtf">'.$this->record_detail['input_date'].'</recordCreationDate>'."\n";
        $_xml_output .= '<recordChangeDate encoding="w3cdtf">'.$this->record_detail['last_update'].'</recordChangeDate>'."\n";
        $_xml_output .= '<recordOrigin>machine generated</recordOrigin>'."\n";
        $_xml_output .= '</recordInfo>';

        $_xml_output .= '</mods>';

        return $_xml_output;
    }


    /**
     * Get Record detail prefix
     */
    public function getPrefix()
    {
        return $this->detail_prefix;
    }


    /**
     * Get Record detail suffix
     */
    public function getSuffix()
    {
        return $this->detail_suffix;
    }
}
?>
