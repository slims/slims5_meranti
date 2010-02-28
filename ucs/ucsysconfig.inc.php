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

// themes base dir
define('THEMES_BASE_DIR', UCS_BASE_DIR.'themes'.DSEP);

// ucs library base dir
define('LIB_DIR', SLIMS_BASE_DIR.'lib'.DSEP);

// ucs includes base dir
define('INC_DIR', UCS_BASE_DIR.'includes'.DSEP);

// images base dir
define('IMAGES_BASE_DIR', UCS_BASE_DIR.'images'.DSEP);

// ucs web doc root dir
$temp_ucs_web_root_dir = preg_replace('@admin.*@i', '', dirname($_SERVER['PHP_SELF']));
define('UCS_WEB_ROOT_DIR', $temp_ucs_web_root_dir.(preg_match('@\/$@i', $temp_ucs_web_root_dir)?'':'/'));

// slims web root dir (assumed ucs installed under SLiMS base directory)
define('SLIMS_WEB_ROOT_DIR', preg_replace('@\/[a-zA-Z0-9]+\/$@i', '/', UCS_WEB_ROOT_DIR));
// define('SLIMS_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR);

// javascript library web root dir
define('JS_WEB_ROOT_DIR', SLIMS_WEB_ROOT_DIR.'js/');

// ucs admin web root dir
define('ADMIN_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR.'admin/');

// ucs themes web root dir
define('THEMES_WEB_ROOT_DIR', UCS_WEB_ROOT_DIR.'themes/');

/* DATABASE CONNECTION config */
// database constant
// change below setting according to your database configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'ucs');
define('DB_USERNAME', 'ucsuser');
define('DB_PASSWORD', 'password_ucsuser');

// database connection file
require 'dbc.inc.php';

// themes
$sysconf['themes'] = 'default';
// check for user language selection if we are not in admin areas
if (stripos($_SERVER['PHP_SELF'], '/admin') === false) {
    if (isset($_GET['select_lang'])) {
        $select_lang = trim(strip_tags($_GET['select_lang']));
        // delete previous language cookie
        if (isset($_COOKIE['select_lang'])) {
            @setcookie('select_lang', $select_lang, time()-14400, SENAYAN_WEB_ROOT_DIR);
        }
        // create language cookie
        @setcookie('select_lang', $select_lang, time()+14400, SENAYAN_WEB_ROOT_DIR);
        $sysconf['default_lang'] = $select_lang;
    } else if (isset($_COOKIE['select_lang'])) {
        $sysconf['default_lang'] = trim(strip_tags($_COOKIE['select_lang']));
    } else {
        $sysconf['default_lang'] = 'id_ID';
    }
}

// catalog search result
$sysconf['opac_result_num'] = 20;

// page footer info
$sysconf['page_footer'] = 'SLiMS Union Catalog Server';

// includes gettext
require LIB_DIR.'lang'.DSEP.'php-gettext'.DSEP.'gettext.inc';

// Apply language settings
require INC_DIR.'localisation.php';

// common files
require INC_DIR.'common.inc.php';
?>
