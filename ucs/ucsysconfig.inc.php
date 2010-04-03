<?php
/**
 * SLiMS Union Catalog server configuration
 *
 * Copyright (C) 2009  Hendro Wicaksono
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
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die();
}

// be sure that magic quote is off
@ini_set('magic_quotes_gpc', false);
@ini_set('magic_quotes_runtime', false);
@ini_set('magic_quotes_sybase', false);
// force disabling magic quotes
if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value)?array_map('stripslashes_deep', $value):stripslashes($value);
        return $value;
    }

    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}
// turn off all error messages for security reason
@ini_set('display_errors', true);

// ucs version
define('UCS_VERSION', 'ucs-1.0');

// redefine directory separator
define('DSEP', DIRECTORY_SEPARATOR);

// ucs base dir
define('UCS_BASE_DIR', realpath(dirname(__FILE__)).DSEP);

// slims base dir (assumed ucs installed under SLiMS base directory)
define('SLIMS_BASE_DIR', preg_replace("@\\".DSEP.'[a-zA-Z0-9]+\\'.DSEP.'$@i', DSEP, UCS_BASE_DIR));
// define('SLIMS_BASE_DIR', UCS_BASE_DIR);

// absolute path for simbio platform
define('SIMBIO_BASE_DIR', SLIMS_BASE_DIR.'simbio2'.DSEP);

// modules base dir
define('MODULES_BASE_DIR', UCS_BASE_DIR.'admin'.DSEP.'modules'.DSEP);

// themes base dir
define('THEMES_BASE_DIR', UCS_BASE_DIR.'themes'.DSEP);
define('ADMIN_THEMES_BASE_DIR', UCS_BASE_DIR.'admin'.DSEP.'admin_themes'.DSEP);

// ucs library base dir
define('LIB_DIR', SLIMS_BASE_DIR.'lib'.DSEP);

// ucs includes base dir
define('INC_DIR', UCS_BASE_DIR.'includes'.DSEP);

// images base dir
define('IMAGES_BASE_DIR', UCS_BASE_DIR.'images'.DSEP);

// ucs web doc root dir
$temp_ucs_web_root_dir = preg_replace('@admin.*@i', '', dirname($_SERVER['PHP_SELF']));
define('UCS_WEB_ROOT_DIR', $temp_ucs_web_root_dir.(preg_match('@\/$@i', $temp_ucs_web_root_dir)?'':'/'));

// modules web root
define('MODULES_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR.'admin/modules/');

// slims web root dir (assumed ucs installed under SLiMS base directory)
define('SLIMS_WEB_ROOT_DIR', preg_replace('@\/[a-zA-Z0-9]+\/$@i', '/', UCS_WEB_ROOT_DIR));
// define('SLIMS_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR);
define('SENAYAN_WEB_ROOT_DIR', SLIMS_WEB_ROOT_DIR);

// javascript library web root dir
define('JS_WEB_ROOT_DIR', SLIMS_WEB_ROOT_DIR.'js/');

// ucs admin web root dir
define('ADMIN_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR.'admin/');

// ucs themes web root dir
define('THEMES_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR.'themes/');

// files dir
define('FILES_DIR', UCS_BASE_DIR.'files'.DIRECTORY_SEPARATOR);

// cookies name
define('UCS_SESSION_COOKIES_NAME', 'ucsadmin');

// command execution status
define('BINARY_NOT_FOUND', 127);
define('BINARY_FOUND', 1);
define('COMMAND_SUCCESS', 0);
define('COMMAND_FAILED', 2);

/* DATABASE CONNECTION config */
// database constant
// change below setting according to your database configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'ucsdb');
define('DB_USERNAME', 'ucsuser');
define('DB_PASSWORD', 'password_ucsuser');

// database connection file
require 'dbc.inc.php';

// themes
$sysconf['themes'] = 'default';

// compability with slims
$sysconf['template']['dir'] = 'themes';
$sysconf['template']['theme'] = $sysconf['themes'];

// catalog search result
$sysconf['opac_result_num'] = 20;

// language
$sysconf['default_lang'] = 'en_US';

// admin session timeout
$sysconf['session_timeout'] = 7200;

// XML
$sysconf['enable_xml_detail'] = true;
$sysconf['enable_xml_result'] = true;

// names
$sysconf['library_name'] = 'Union Catalog Server';
$sysconf['library_subname'] = 'SLiMS';

/* SYSTEM LIBRARIES */
// include utility library
require LIB_DIR.'utility.inc.php';
// simbio main class inclusion
require SIMBIO_BASE_DIR.'simbio.inc.php';
// simbio security class
require SIMBIO_BASE_DIR.'simbio_UTILS'.DIRECTORY_SEPARATOR.'simbio_security.inc.php';
// includes gettext
require LIB_DIR.'lang'.DSEP.'php-gettext'.DSEP.'gettext.inc';
// Apply language settings
require INC_DIR.'localisation.php';

// check if we are in mobile browser mode
if (utility::isMobileBrowser()) { define('LIGHTWEIGHT_MODE', 1); }

// load settings from database
utility::loadSettings($dbs);

// check for user language selection if we are not in admin areas
if (stripos($_SERVER['PHP_SELF'], '/admin') === false) {
    if (isset($_GET['select_lang'])) {
        $select_lang = trim(strip_tags($_GET['select_lang']));
        // delete previous language cookie
        if (isset($_COOKIE['select_lang'])) {
            @setcookie('select_lang', $select_lang, time()-14400, UCS_WEB_ROOT_DIR);
        }
        // create language cookie
        @setcookie('select_lang', $select_lang, time()+14400, UCS_WEB_ROOT_DIR);
        $sysconf['default_lang'] = $select_lang;
    } else if (isset($_COOKIE['select_lang'])) {
        $sysconf['default_lang'] = trim(strip_tags($_COOKIE['select_lang']));
    }
}

// AJAX security
$sysconf['ajaxsec_user'] = 'slimsajax';
$sysconf['ajaxsec_passwd'] = 'passwdslimsajax';

// base URL
$sysconf['baseurl'] = UCS_WEB_ROOT_DIR;

// enable HTTPS
$sysconf['https_enable'] = false;

/* XML */
$sysconf['enable_xml_detail'] = true;
$sysconf['enable_xml_result'] = true;

// page footer info
$sysconf['page_footer'] = 'SLiMS Union Catalog Server';

// mysqldump
$sysconf['mysqldump'] = '/usr/bin/mysqldump';
$sysconf['backup_dir'] = FILES_DIR.'backup'.DIRECTORY_SEPARATOR;

/* FILE UPLOADS */
$sysconf['max_upload'] = intval(ini_get('upload_max_filesize'))*1024;
$post_max_size = intval(ini_get('post_max_size'))*1024;
if ($sysconf['max_upload'] > $post_max_size) {
    $sysconf['max_upload'] = $post_max_size-1024;
}
$sysconf['max_image_upload'] = 500;
// allowed image file to upload
$sysconf['allowed_images'] = array('.jpeg', '.jpg', '.gif', '.png', '.JPEG', '.JPG', '.GIF', '.PNG');
// allowed file attachment to upload
$sysconf['allowed_file_att'] = array('.pdf', '.rtf', '.txt',
    '.odt', '.odp', '.ods', '.doc', '.xls', '.ppt',
    '.avi', '.mpeg', '.mp4', '.flv', '.mvk',
    '.jpg', '.jpeg', '.png', '.gif',
    '.ogg', '.mp3');

/* FILE ATTACHMENT MIMETYPES */
$sysconf['mimetype']['js'] = 'application/javascript';
$sysconf['mimetype']['json'] = 'application/json';
$sysconf['mimetype']['doc'] = 'application/msword';
$sysconf['mimetype']['dot'] = 'application/msword';
$sysconf['mimetype']['ogg'] = 'application/ogg';
$sysconf['mimetype']['pdf'] = 'application/pdf';
$sysconf['mimetype']['rdf'] = 'application/rdf+xml';
$sysconf['mimetype']['rss'] = 'application/rss+xml';
$sysconf['mimetype']['rtf'] = 'application/rtf';
$sysconf['mimetype']['xls'] = 'application/vnd.ms-excel';
$sysconf['mimetype']['xlt'] = 'application/vnd.ms-excel';
$sysconf['mimetype']['chm'] = 'application/vnd.ms-htmlhelp';
$sysconf['mimetype']['ppt'] = 'application/vnd.ms-powerpoint';
$sysconf['mimetype']['pps'] = 'application/vnd.ms-powerpoint';
$sysconf['mimetype']['odc'] = 'application/vnd.oasis.opendocument.chart';
$sysconf['mimetype']['odf'] = 'application/vnd.oasis.opendocument.formula';
$sysconf['mimetype']['odg'] = 'application/vnd.oasis.opendocument.graphics';
$sysconf['mimetype']['odi'] = 'application/vnd.oasis.opendocument.image';
$sysconf['mimetype']['odp'] = 'application/vnd.oasis.opendocument.presentation';
$sysconf['mimetype']['ods'] = 'application/vnd.oasis.opendocument.spreadsheet';
$sysconf['mimetype']['odt'] = 'application/vnd.oasis.opendocument.text';
$sysconf['mimetype']['swf'] = 'application/x-shockwave-flash';
$sysconf['mimetype']['zip'] = 'application/zip';
$sysconf['mimetype']['mp3'] = 'audio/mpeg';
$sysconf['mimetype']['jpg'] = 'image/jpeg';
$sysconf['mimetype']['gif'] = 'image/gif';
$sysconf['mimetype']['png'] = 'image/png';
$sysconf['mimetype']['flv'] = 'video/x-flv';
$sysconf['mimetype']['mp4'] = 'video/mp4';

/* AUTHORITY TYPE */
$sysconf['authority_type']['p'] = __('Personal Name');
$sysconf['authority_type']['o'] = __('Organizational Body');
$sysconf['authority_type']['c'] = __('Conference');

/* SUBJECT/AUTHORITY TYPE */
$sysconf['subject_type']['t'] = __('Topic');
$sysconf['subject_type']['g'] = __('Geographic');
$sysconf['subject_type']['n'] = __('Name');
$sysconf['subject_type']['tm'] = __('Temporal');
$sysconf['subject_type']['gr'] = __('Genre');
$sysconf['subject_type']['oc'] = __('Occupation');

/* AUTHORITY LEVEL */
$sysconf['authority_level'][1] = __('Primary Author');
$sysconf['authority_level'][2] = __('Additional Author');
$sysconf['authority_level'][3] = __('Editor');
$sysconf['authority_level'][4] = __('Translator');
$sysconf['authority_level'][5] = __('Director');
$sysconf['authority_level'][6] = __('Producer');
$sysconf['authority_level'][7] = __('Composer');
$sysconf['authority_level'][8] = __('Illustrator');
$sysconf['authority_level'][9] = __('Creator');
$sysconf['authority_level'][10] = __('Contributor');

// redirect to mobile template on mobile mode
if (defined('LIGHTWEIGHT_MODE') OR isset($_COOKIE['LIGHTWEIGHT_MODE'])) {
    $sysconf['template']['theme'] = 'lightweight';
    $sysconf['template']['css'] = $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/style.css';
    $sysconf['enable_xml_detail'] = false;
    $sysconf['enable_xml_result'] = false;
}

// Include server configuration
require 'ucserver.inc.php';

// check if session is auto started and then destroy it
if ($is_auto = @ini_get('session.auto_start')) { define('SESSION_AUTO_STARTED', $is_auto); }
if (defined('SESSION_AUTO_STARTED')) { @session_destroy(); }

/* Force UTF-8 for MySQL connection and HTTP header */
header('Content-type: text/html; charset=UTF-8');
$dbs->query('SET NAMES \'utf8\'');
?>
