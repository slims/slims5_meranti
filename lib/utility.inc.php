<?php
/**
 * utility class
 * A Collection of static utility methods
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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

class utility
{
    /**
     * Static Method to send out javascript alert
     *
     * @param   string  $str_message
     * @return  void
     */
    public static function jsAlert($str_message)
    {
        if (!$str_message) {
            return;
        }

        // replace newline with javascripts newline
        $str_message = str_replace("\n", '\n', $str_message);
        echo '<script type="text/javascript">'."\n";
        echo 'alert("'.addslashes($str_message).'")'."\n";
        echo '</script>'."\n";
    }


    /**
     * Static Method to create random string
     *
     * @param   int     $int_num_string: number of randowm string to created
     * @return  void
     */
    public static function createRandomString($int_num_string = 32)
    {
      $_random = '';
      $_salt = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      for ($r = 0; $r < $int_num_string; $r++) {
        $_random .= $_salt[mt_srand(strlen($_salt))];
      }

      return $_random;
    }


    /**
     * Static Method to load application settings from database
     *
     * @param   object  $obj_db
     * @return  void
     */
    public static function loadSettings($obj_db)
    {
        global $sysconf;
        $_setting_query = $obj_db->query('SELECT * FROM setting');
        if (!$obj_db->errno) {
            while ($_setting_data = $_setting_query->fetch_assoc()) {
                $_value = unserialize($_setting_data['setting_value']);
                if (is_array($_value)) {
                    foreach ($_value as $_idx=>$_curr_value) {
                        $sysconf[$_setting_data['setting_name']][$_idx] = $_curr_value;
                    }
                } else {
                    $sysconf[$_setting_data['setting_name']] = $_value;
                }
            }
        }
    }


    /**
     * Static Method to check privileges of application module form current user
     *
     * @param   string  $str_module_name
     * @param   string  $str_privilege_type
     * @return  boolean
     */
    public static function havePrivilege($str_module_name, $str_privilege_type = 'r')
    {
        // checking checksum
        $server_addr = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : (isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']));
        $_checksum = defined('UCS_BASE_DIR')?md5($server_addr.UCS_BASE_DIR.'admin'):md5($server_addr.SENAYAN_BASE_DIR.'admin');
        if ($_SESSION['checksum'] != $_checksum) {
            return false;
        }
        // check privilege type
        if (!in_array($str_privilege_type, array('r', 'w'))) {
            return false;
        }
        if (isset($_SESSION['priv'][$str_module_name][$str_privilege_type]) AND $_SESSION['priv'][$str_module_name][$str_privilege_type]) {
            return true;
        }
        return false;
    }


    /**
     * Static Method to write application activities logs
     *
     * @param   object  $obj_db
     * @param   string  $str_log_type
     * @param   string  $str_value_id
     * @param   string  $str_location
     * @param   string  $str_log_msg
     * @return  void
     */
    public static function writeLogs($obj_db, $str_log_type, $str_value_id, $str_location, $str_log_msg)
    {
        if (!$obj_db->error) {
            // log table
            $_log_date = date('Y-m-d H:i:s');
            $_log_table = 'system_log';
            // filter input
            $str_log_type = $obj_db->escape_string(trim($str_log_type));
            $str_value_id = $obj_db->escape_string(trim($str_value_id));
            $str_location = $obj_db->escape_string(trim($str_location));
            $str_log_msg = $obj_db->escape_string(trim($str_log_msg));
            // insert log data to database
            @$obj_db->query('INSERT INTO '.$_log_table.'
            VALUES (NULL, \''.$str_log_type.'\', \''.$str_value_id.'\', \''.$str_location.'\', \''.$str_log_msg.'\', \''.$_log_date.'\')');
        }
    }


    /**
     * Static Method to get an ID of database table record
     *
     * @param   object  $obj_db
     * @param   string  $str_table_name
     * @param   string  $str_id_field
     * @param   string  $str_value_field
     * @param   string  $str_value
     * @param   array   $arr_cache
     * @return  mixed
     */
    public static function getID($obj_db, $str_table_name, $str_id_field, $str_value_field, $str_value, &$arr_cache = false)
    {
        $str_value = trim($str_value);
        if ($arr_cache) {
            if (isset($arr_cache[$str_value])) {
                return $arr_cache[$str_value];
            }
        }
        if (!$obj_db->error) {
            $id_q = $obj_db->query('SELECT '.$str_id_field.' FROM '.$str_table_name.' WHERE '.$str_value_field.'=\''.$obj_db->escape_string($str_value).'\'');
            if ($id_q->num_rows > 0) {
                $id_d = $id_q->fetch_row();
                unset($id_q);
                // cache
                if ($arr_cache) {
                    $arr_cache[$str_value] = $id_d[0];
                }
                return $id_d[0];
            } else {
                $_curr_date = date('Y-m-d');
                // if not found then we insert it as new value
                $obj_db->query('INSERT IGNORE INTO '.$str_table_name.' ('.$str_value_field.', input_date, last_update)
                    VALUES (\''.$obj_db->escape_string($str_value).'\', \''.$_curr_date.'\', \''.$_curr_date.'\')');
                if (!$obj_db->error) {
                    // cache
                    if ($arr_cache) {
                        $arr_cache[$str_value] = $obj_db->insert_id;
                    }
                    return $obj_db->insert_id;
                }
            }
        }
    }


    /**
     * Static method to detect mobile browser
     * Some Patches by Indra Sutriadi
     *
     * @return  boolean
     * this script is taken from http://mobiforge.com/developing/story/lightweight-device-detection-php
     **/
    public static function isMobileBrowser()
    {
        $_is_mobile_browser = '0';

        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower(@$_SERVER['HTTP_USER_AGENT']))) {
            $_is_mobile_browser++;
        }

        if((strpos(strtolower(@$_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $_is_mobile_browser++;
        }

        $_mobile_ua = strtolower(substr(@$_SERVER['HTTP_USER_AGENT'],0,4));
        $_mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-');

        if(in_array($_mobile_ua, $_mobile_agents)) {
            $_is_mobile_browser++;
        }

        if (isset($_SERVER['ALL_HTTP']) && strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),' ppc;')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),'windows ce')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),'windows')>0) {
            $_is_mobile_browser=0;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),'iemobile')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_ACCEPT']),'j2me')>0 || strpos(strtolower(@$_SERVER['HTTP_ACCEPT']),'midp')>0) {
            $_is_mobile_browser++;
        }

        if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE'])) {
            $_is_mobile_browser++;
        }

        if ($_is_mobile_browser > 0) {
            return true;
        }
        return false;
    }


    /**
     * Static method to check if member already logged in or not
     *
     * @return  boolean
     **/
    public static function isMemberLogin()
    {
        $_logged_in = false;
        $_logged_in = isset($_SESSION['mid']) && isset($_SESSION['m_name']) && isset($_SESSION['m_email']);
        return $_logged_in;
    }


    /**
     * Static method to filter data
     *
     * @param   mixed   $mix_input: input data
     * @param   string  $str_input_type: input type
     * @param   boolean $bool_trim: are input string trimmed
     *
     * @return  mixed
     **/
    public static function filterData($mix_input, $str_input_type = 'get', $bool_escape_sql = true, $bool_trim = true, $bool_strip_html = false) {
        global $dbs;

        if (extension_loaded('filter')) {
            if ($str_input_type == 'var') {
                $mix_input = filter_var($mix_input, FILTER_SANITIZE_STRING);
            } else if ($str_input_type == 'post') {
                $mix_input = filter_input(INPUT_POST, $mix_input);
            } else if ($str_input_type == 'cookie') {
                $mix_input = filter_input(INPUT_COOKIE, $mix_input);
            } else if ($str_input_type == 'session') {
                $mix_input = filter_input(INPUT_SESSION, $mix_input);
            } else {
                $mix_input = filter_input(INPUT_GET, $mix_input);
            }
        }

        // trim whitespace on string
        if ($bool_trim) { $mix_input = trim($mix_input); }
        // strip html
        if ($bool_strip_html) { $mix_input = strip_tags($mix_input); }
        // escape SQL string
        if ($bool_escape_sql) { $mix_input = $dbs->escape_string($mix_input); }

        return $mix_input;
    }


    /**
     * Static method to convert XML entities
     * Code taken and modified from:
     * Matt Robinson at http://inanimatt.com/php-convert-entities.html
     *
     * @param   string  $str_xml_data: string of xml data to check
     *
     * @return  string
     **/
    public static function convertXMLentities($str_xml_data) {
      static $_ent_table = array('quot' => '&#34;',
        'amp' => '&#38;',
        'lt' => '&#60;',
        'gt' => '&#62;',
        'OElig' => '&#338;',
        'oelig' => '&#339;',
        'Scaron' => '&#352;',
        'scaron' => '&#353;',
        'Yuml' => '&#376;',
        'circ' => '&#710;',
        'tilde' => '&#732;',
        'ensp' => '&#8194;',
        'emsp' => '&#8195;',
        'thinsp' => '&#8201;',
        'zwnj' => '&#8204;',
        'zwj' => '&#8205;',
        'lrm' => '&#8206;',
        'rlm' => '&#8207;',
        'ndash' => '&#8211;',
        'mdash' => '&#8212;',
        'lsquo' => '&#8216;',
        'rsquo' => '&#8217;',
        'sbquo' => '&#8218;',
        'ldquo' => '&#8220;',
        'rdquo' => '&#8221;',
        'bdquo' => '&#8222;',
        'dagger' => '&#8224;',
        'Dagger' => '&#8225;',
        'permil' => '&#8240;',
        'lsaquo' => '&#8249;',
        'rsaquo' => '&#8250;',
        'euro' => '&#8364;',
        'fnof' => '&#402;',
        'Alpha' => '&#913;',
        'Beta' => '&#914;',
        'Gamma' => '&#915;',
        'Delta' => '&#916;',
        'Epsilon' => '&#917;',
        'Zeta' => '&#918;',
        'Eta' => '&#919;',
        'Theta' => '&#920;',
        'Iota' => '&#921;',
        'Kappa' => '&#922;',
        'Lambda' => '&#923;',
        'Mu' => '&#924;',
        'Nu' => '&#925;',
        'Xi' => '&#926;',
        'Omicron' => '&#927;',
        'Pi' => '&#928;',
        'Rho' => '&#929;',
        'Sigma' => '&#931;',
        'Tau' => '&#932;',
        'Upsilon' => '&#933;',
        'Phi' => '&#934;',
        'Chi' => '&#935;',
        'Psi' => '&#936;',
        'Omega' => '&#937;',
        'alpha' => '&#945;',
        'beta' => '&#946;',
        'gamma' => '&#947;',
        'delta' => '&#948;',
        'epsilon' => '&#949;',
        'zeta' => '&#950;',
        'eta' => '&#951;',
        'theta' => '&#952;',
        'iota' => '&#953;',
        'kappa' => '&#954;',
        'lambda' => '&#955;',
        'mu' => '&#956;',
        'nu' => '&#957;',
        'xi' => '&#958;',
        'omicron' => '&#959;',
        'pi' => '&#960;',
        'rho' => '&#961;',
        'sigmaf' => '&#962;',
        'sigma' => '&#963;',
        'tau' => '&#964;',
        'upsilon' => '&#965;',
        'phi' => '&#966;',
        'chi' => '&#967;',
        'psi' => '&#968;',
        'omega' => '&#969;',
        'thetasym' => '&#977;',
        'upsih' => '&#978;',
        'piv' => '&#982;',
        'bull' => '&#8226;',
        'hellip' => '&#8230;',
        'prime' => '&#8242;',
        'Prime' => '&#8243;',
        'oline' => '&#8254;',
        'frasl' => '&#8260;',
        'weierp' => '&#8472;',
        'image' => '&#8465;',
        'real' => '&#8476;',
        'trade' => '&#8482;',
        'alefsym' => '&#8501;',
        'larr' => '&#8592;',
        'uarr' => '&#8593;',
        'rarr' => '&#8594;',
        'darr' => '&#8595;',
        'harr' => '&#8596;',
        'crarr' => '&#8629;',
        'lArr' => '&#8656;',
        'uArr' => '&#8657;',
        'rArr' => '&#8658;',
        'dArr' => '&#8659;',
        'hArr' => '&#8660;',
        'forall' => '&#8704;',
        'part' => '&#8706;',
        'exist' => '&#8707;',
        'empty' => '&#8709;',
        'nabla' => '&#8711;',
        'isin' => '&#8712;',
        'notin' => '&#8713;',
        'ni' => '&#8715;',
        'prod' => '&#8719;',
        'sum' => '&#8721;',
        'minus' => '&#8722;',
        'lowast' => '&#8727;',
        'radic' => '&#8730;',
        'prop' => '&#8733;',
        'infin' => '&#8734;',
        'ang' => '&#8736;',
        'and' => '&#8743;',
        'or' => '&#8744;',
        'cap' => '&#8745;',
        'cup' => '&#8746;',
        'int' => '&#8747;',
        'there4' => '&#8756;',
        'sim' => '&#8764;',
        'cong' => '&#8773;',
        'asymp' => '&#8776;',
        'ne' => '&#8800;',
        'equiv' => '&#8801;',
        'le' => '&#8804;',
        'ge' => '&#8805;',
        'sub' => '&#8834;',
        'sup' => '&#8835;',
        'nsub' => '&#8836;',
        'sube' => '&#8838;',
        'supe' => '&#8839;',
        'oplus' => '&#8853;',
        'otimes' => '&#8855;',
        'perp' => '&#8869;',
        'sdot' => '&#8901;',
        'lceil' => '&#8968;',
        'rceil' => '&#8969;',
        'lfloor' => '&#8970;',
        'rfloor' => '&#8971;',
        'lang' => '&#9001;',
        'rang' => '&#9002;',
        'loz' => '&#9674;',
        'spades' => '&#9824;',
        'clubs' => '&#9827;',
        'hearts' => '&#9829;',
        'diams' => '&#9830;',
        'nbsp' => '&#160;',
        'iexcl' => '&#161;',
        'cent' => '&#162;',
        'pound' => '&#163;',
        'curren' => '&#164;',
        'yen' => '&#165;',
        'brvbar' => '&#166;',
        'sect' => '&#167;',
        'uml' => '&#168;',
        'copy' => '&#169;',
        'ordf' => '&#170;',
        'laquo' => '&#171;',
        'not' => '&#172;',
        'shy' => '&#173;',
        'reg' => '&#174;',
        'macr' => '&#175;',
        'deg' => '&#176;',
        'plusmn' => '&#177;',
        'sup2' => '&#178;',
        'sup3' => '&#179;',
        'acute' => '&#180;',
        'micro' => '&#181;',
        'para' => '&#182;',
        'middot' => '&#183;',
        'cedil' => '&#184;',
        'sup1' => '&#185;',
        'ordm' => '&#186;',
        'raquo' => '&#187;',
        'frac14' => '&#188;',
        'frac12' => '&#189;',
        'frac34' => '&#190;',
        'iquest' => '&#191;',
        'Agrave' => '&#192;',
        'Aacute' => '&#193;',
        'Acirc' => '&#194;',
        'Atilde' => '&#195;',
        'Auml' => '&#196;',
        'Aring' => '&#197;',
        'AElig' => '&#198;',
        'Ccedil' => '&#199;',
        'Egrave' => '&#200;',
        'Eacute' => '&#201;',
        'Ecirc' => '&#202;',
        'Euml' => '&#203;',
        'Igrave' => '&#204;',
        'Iacute' => '&#205;',
        'Icirc' => '&#206;',
        'Iuml' => '&#207;',
        'ETH' => '&#208;',
        'Ntilde' => '&#209;',
        'Ograve' => '&#210;',
        'Oacute' => '&#211;',
        'Ocirc' => '&#212;',
        'Otilde' => '&#213;',
        'Ouml' => '&#214;',
        'times' => '&#215;',
        'Oslash' => '&#216;',
        'Ugrave' => '&#217;',
        'Uacute' => '&#218;',
        'Ucirc' => '&#219;',
        'Uuml' => '&#220;',
        'Yacute' => '&#221;',
        'THORN' => '&#222;',
        'szlig' => '&#223;',
        'agrave' => '&#224;',
        'aacute' => '&#225;',
        'acirc' => '&#226;',
        'atilde' => '&#227;',
        'auml' => '&#228;',
        'aring' => '&#229;',
        'aelig' => '&#230;',
        'ccedil' => '&#231;',
        'egrave' => '&#232;',
        'eacute' => '&#233;',
        'ecirc' => '&#234;',
        'euml' => '&#235;',
        'igrave' => '&#236;',
        'iacute' => '&#237;',
        'icirc' => '&#238;',
        'iuml' => '&#239;',
        'eth' => '&#240;',
        'ntilde' => '&#241;',
        'ograve' => '&#242;',
        'oacute' => '&#243;',
        'ocirc' => '&#244;',
        'otilde' => '&#245;',
        'ouml' => '&#246;',
        'divide' => '&#247;',
        'oslash' => '&#248;',
        'ugrave' => '&#249;',
        'uacute' => '&#250;',
        'ucirc' => '&#251;',
        'uuml' => '&#252;',
        'yacute' => '&#253;',
        'thorn' => '&#254;',
        'yuml' => '&#255;'
        );

      // Entity not found? Destroy it.
      return isset($_ent_table[$matches[1]]) ? $_ent_table[$matches[1]] : '';
    }
}
