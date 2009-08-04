<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
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

/* Circulation section */

if (!defined('SENAYAN_BASE_DIR')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
}

require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_element.inc.php';

// privileges checking
$can_read = utility::havePrivilege('circulation', 'r');
$can_write = utility::havePrivilege('circulation', 'w');

if (!($can_read AND $can_write)) {
    die('<div class="errorBox">'.lang_sys_common_no_privilege.'</div>');
}
// check if there is transaction running
if (isset($_SESSION['memberID']) AND !empty($_SESSION['memberID'])) {
    define('DIRECT_INCLUDE', true);
    include MODULES_BASE_DIR.'circulation/circulation_action.php';
} else {
?>
    <fieldset class="menuBox">
        <div class="menuBoxInner circulationIcon">
            <?php echo lang_mod_circ_common_welcome; ?>
            <hr />
            <form id="startCirc" method="post" style="display: inline;" action="blank.html" target="blindSubmit" onsubmit="$('start').click();">
            <?php echo lang_mod_circ_field_member_id; ?> :
            <?php
            // create AJAX drop down
            $ajaxDD = new simbio_fe_AJAX_select();
            $ajaxDD->element_name = 'memberID';
            $ajaxDD->element_css_class = 'ajaxInputField';
            $ajaxDD->handler_URL = MODULES_WEB_ROOT_DIR.'membership/member_AJAX_response.php';
            echo $ajaxDD->out();
            ?>
            <input type="button" value="<?php echo lang_mod_circ_start; ?>" id="start" class="button" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>circulation/circulation_action.php', 'post', $('startCirc').serialize(), true)" />
            </form>
        </div>
    </fieldset>
    <script type="text/javascript">
    // focus member ID text field
    $('memberID').focus();
    </script>
<?php
    if (isset($_POST['finishID'])) {
        $msg = str_ireplace('{member_id}', $_POST['finishID'], lang_mod_circ_common_trans_finish);
        echo '<div class="infoBox">'.$msg.'</div>';
    }
}
?>
