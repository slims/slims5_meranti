<?php
/**
 *
 * Visitor Counter
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

$allowed_counter_ip = array('127.0.0.1');
$remote_addr = $_SERVER['REMOTE_ADDR'];
$confirmation = 0;

foreach ($allowed_counter_ip as $ip) {
    if ($ip == $remote_addr) {
        $confirmation = 1;
    }
}

if (!$confirmation) {
    header ("location:index.php");
}

// start the output buffering for main content
ob_start();

define('INSTITUTION_EMPTY', 11);

if (isset($_POST['counter'])) {
    $member_name = 'Guest';
    $photo = 'person.png';
    // sleep for a while
    sleep(1);
    /**
     * Insert counter data to database
     */
    function setCounter($str_member_ID) {
        global $dbs, $member_name, $photo;
        // check if ID exists
        $str_member_ID = $dbs->escape_string($str_member_ID);
        $_q = $dbs->query("SELECT * FROM member WHERE member_id='$str_member_ID'");
        // if member is already registered
        if ($_q->num_rows > 0) {
            $_d = $_q->fetch_assoc();
            $member_id = $_d['member_id'];
            $member_name = $_d['member_name'];
            $photo = trim($_d['member_image'])?trim($_d['member_image']):'person.png';
            $_institution = trim($_d['inst_name'])?"'".$_d['inst_name']."'":'NULL';
            $_checkin_date = date('Y-m-d H:i:s');
            $_i = $dbs->query("INSERT INTO visitor_count (member_id, member_name, institution, checkin_date) VALUES ('$member_id', '$member_name', $_institution, '$_checkin_date')");
        } else {
            // non member
            $_d = $_q->fetch_assoc();
            $member_name = $dbs->escape_string(trim($_POST['memberID']));
            $_institution = $dbs->escape_string(trim($_POST['institution']));
            $_checkin_date = date('Y-m-d H:i:s');
            if (!$_institution) {
                return INSTITUTION_EMPTY;
            } else {
                $_i = $dbs->query("INSERT INTO visitor_count (member_name, institution, checkin_date) VALUES ('$member_name', '$_institution', '$_checkin_date')");
            }
        }
        return true;
    }


    $memberID = trim($_POST['memberID']);
    $counter = setCounter($memberID);
    if ($counter === true) {
        echo __($member_name.', thank you for inserting your data to our visitor log').'<span id="memberImage" src="images/persons/'.urlencode($photo).'"></span>';
    } else if ($counter === INSTITUTION_EMPTY) {
        echo __('Sorry, Please fill institution field if you are not library member');
    } else {
        echo __('Error inserting counter data to database!');
    }
    exit();
}

?>

<fieldset id="visitorCounterWrap">
<legend><?php echo __('Visitor Counter'); ?></legend>
<div id="counterInfo"></div>
<div class="info"><?php echo __('Please insert your library member ID otherwise your full name instead'); ?></div>
<form action="index.php?p=visitor" name="visitorCounterForm" id="visitorCounterForm" method="post">
    <div class="fieldLabel"><?php echo __('Member ID'); ?>/<?php echo __('Visitor Name'); ?>*</div>
    <div><input type="text" name="memberID" id="memberID" /></div>
    <div class="fieldLabel"><?php echo __('Institution'); ?></div>
    <div><input type="text" name="institution" id="institution" /></div>
    <div class="marginTop"><input type="submit" name="counter" value="<?php echo __('Add'); ?>" />
</div>
</form>
<img id="visitorCounterPhoto" src="images/persons/person.png" />
</fieldset>

<script type="text/javascript">
    // give focus to first field
    jQuery('#memberID').focus();

    var visitorCounterForm = jQuery('#visitorCounterForm');

    // AJAX counter error handler
    function counterError(ajax) {
        alert('Error inserting counter data to database!');
        visitorCounterForm.find('input[type=text]').val('');
        jQuery('#memberID').focus();
    }

    // AJAX counter complete handler
    function counterComplete(ajax) {
        visitorCounterForm.find('input[type=text]').val('');
        var memberImage = jQuery('#memberImage');
        if (memberImage) {
            // update visitor photo
            var imageSRC = memberImage.attr('src'); memberImage.remove();
            jQuery('#visitorCounterPhoto')[0].src = imageSRC;
        }
        jQuery('#memberID').focus();
    }

    // register event
    visitorCounterForm.submit(function(evt) {
        evt.preventDefault();
        var theForm = jQuery(this);
        var formAction = theForm.attr('action');
        var formData = theForm.serialize();
        // block the form
        theForm.disable();
        jQuery('#counterInfo').css({'display': 'block'}).html('PLEASE WAIT...');
        // create AJAX request for submitting form
        jQuery.ajax(
            { url: formAction,
                type: 'POST',
                async: false,
                data: formData,
                cache: false,
                success: function(respond) {
                    jQuery('#counterInfo').html(respond);
                }
            });
    });
</script>

<?php
// main content
$main_content = ob_get_clean();
// page title
$page_title = $sysconf['library_name'].' :: Visitor Counter';
require_once $sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/login_template.inc.php';
exit();
?>
