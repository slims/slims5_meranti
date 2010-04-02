<?php
/**
 *
 * Librarian login page
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

if (defined('LIGHTWEIGHT_MODE')) {
    header('Location: index.php');
}

// required file
require LIB_DIR.'admin_logon.inc.php';

// https connection (if enabled)
if ($sysconf['https_enable']) {
    simbio_security::doCheckHttps($sysconf['https_port']);
}

// check if session browser cookie already exists
if (isset($_COOKIE['admin_logged_in'])) {
    header('location: admin/index.php');
}

// start the output buffering for main content
ob_start();

// if there is login action
if (isset($_POST['logMeIn'])) {
    $username = trim(strip_tags($_POST['userName']));
    $password = trim(strip_tags($_POST['passWord']));
    if (!$username OR !$password) {
        echo '<script type="text/javascript">alert(\''.__('Please supply valid username and password').'\');</script>';
    } else {
        // destroy previous session set in OPAC
        simbio_security::destroySessionCookie(null, SENAYAN_MEMBER_SESSION_COOKIES_NAME, SENAYAN_WEB_ROOT_DIR, false);
        require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
        // regenerate session ID to prevent session hijacking
        session_regenerate_id(true);
        // create logon class instance
        $logon = new admin_logon($username, $password);
        if ($logon->adminValid($dbs)) {
            // set cookie admin flag
            setcookie('admin_logged_in', true, time()+14400, SENAYAN_WEB_ROOT_DIR);
            // write log
            utility::writeLogs($dbs, 'staff', $username, 'Login', 'Login success for user '.$username.' from address '.$_SERVER['REMOTE_ADDR']);
            echo '<script type="text/javascript">';
            echo 'alert(\''.__('Welcome to Library Automation, ').$logon->real_name.'\');';
            echo 'location.href = \'admin/index.php\';';
            echo '</script>';
            exit();
        } else {
            // write log
            utility::writeLogs($dbs, 'staff', $username, 'Login', 'Login FAILED for user '.$username.' from address '.$_SERVER['REMOTE_ADDR']);
            // message
            $msg = '<script type="text/javascript">';
            $msg .= 'alert(\''.__('Wrong Username or Password. ACCESS DENIED').'\');';
            $msg .= 'history.back();';
            $msg .= '</script>';
            simbio_security::destroySessionCookie($msg, SENAYAN_SESSION_COOKIES_NAME, SENAYAN_WEB_ROOT_DIR.'admin', false);
            exit();
        }
    }
}
?>

<div id="loginForm">
    <noscript>
        <div style="font-weight: bold; color: #FF0000;"><?php echo __('Your browser does not support Javascript or Javascript is disabled. Application won\'t run without Javascript!'); ?><div>
    </noscript>
    <form action="index.php?p=login" method="post">
    <div class="heading1">Username</div>
    <div><input type="text" name="userName" style="width: 80%;" /></div>
    <div class="heading1 marginTop">Password</div>
    <div><input type="password" name="passWord" style="width: 80%;" /></div>
    <div class="marginTop"><input type="submit" name="logMeIn" value="Logon" id="loginButton" />
        <input type="button" value="Home" id="homeButton" onclick="javascript: location.href = 'index.php';" />
    </div>
    </form>
</div>

<?php
// main content
$main_content = ob_get_clean();

// page title
$page_title = $sysconf['library_name'].' :: Library Automation LOGIN';

if ($sysconf['template']['base'] == 'html') {
    // create the template object
    $template = new simbio_template_parser($sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/login_template.html');
    // assign content to markers
    $template->assign('<!--PAGE_TITLE-->', $page_title);
    $template->assign('<!--CSS-->', $sysconf['template']['css']);
    $template->assign('<!--MAIN_CONTENT-->', $main_content);
    // print out the template
    $template->printOut();
} else if ($sysconf['template']['base'] == 'php') {
    require_once $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/login_template.inc.php';
}
exit();
?>
