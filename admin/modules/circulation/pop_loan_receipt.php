<?php
/**
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


/* Loan Circulation Receipt Pop Windows */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SENAYAN_BASE_DIR.'admin/admin_template/printed_settings.inc.php';

// page title
$page_title = 'Loan Receipt';

// start the output buffer
ob_start();
/* main content */
?>
<style type="text/css">
#receiptBody {
  margin: <?php echo $receipt_margin; ?>;
  padding: <?php echo $receipt_padding; ?>;
  color: <?php echo $receipt_color; ?>;
  font-family: <?php echo $receipt_font; ?>;
  width: <?php echo $receipt_width; ?>;
  border: <?php echo $receipt_border; ?>;
}

#receiptBody * {
  color: #000;
  font-family: serif;
  font-size: <?php echo $receipt_fontSize; ?>;
}

.receiptHeader {
  font-weight: bold;
  font-size: <?php echo $receipt_header_fontSize; ?>;
}

table td {
  vertical-align: top;
}
</style>
<?php ob_start(); ?>
<div id="receiptBody">
    <table width="100%">
    <tr>
        <td><div id="receiptTitle"><?php echo $sysconf['library_name'] ?><br /><?php echo $sysconf['library_subname'] ?></div></td>
        <td><div id="receiptMember"><?php echo $_SESSION['receipt_record']['memberName'] ?> (<?php echo $_SESSION['receipt_record']['memberID'] ?>)</div>
        <div id="receiptDate"><?php echo $_SESSION['receipt_record']['date'] ?></div></td>
    </tr>
    </table>
    
    <hr />
    <div id="receiptInfo">
        <!-- LOAN -->
        <?php if (isset($_SESSION['receipt_record']['loan']) || isset($_SESSION['receipt_record']['extend'])) { ?>
        <div class="receiptHeader">Type of Transaction: <?php echo __('Loan'); ?>/<?php echo __('Extended'); ?> (<?php echo mt_rand(000000000, 999999999); ?>)</div>
        <hr size="1" noshade="noshade" />
        <table width="100%">
        <tr><td>Code</td><td>Title</td><td>Loan</td><td>Due</td></tr>
        <?php
        if (isset($_SESSION['receipt_record']['loan'])) {
            foreach ($_SESSION['receipt_record']['loan'] as $loan) {
                echo '<tr>';
                echo '<td>'.$loan['itemCode'].'</td>';
                echo '<td>'.substr($loan['title'], 0, $receipt_titleLength);
                if (strlen($loan['title']) > $receipt_titleLength) {
                    echo ' ...';
                }
                echo '.</td>';
                echo '<td>'.$loan['loanDate'].'</td>';
                echo '<td>'.$loan['dueDate'].'</td>';
                echo '</tr>';
            }
        }        
        
        // loan extend
        if (isset($_SESSION['receipt_record']['extend'])) {
            foreach ($_SESSION['receipt_record']['extend'] as $ext) {
                echo '<tr>';
                echo '<td>'.$ext['itemCode'].'</td>';
                #echo '<td>'.substr($ext['title'], 0, 50).'...<br />-- extended --</td>';
                
                echo '<td>'.substr($ext['title'], 0, $receipt_titleLength);
                if (strlen($ext['title']) > $receipt_titleLength) {
                    echo ' ...';
                }
                echo '. <strong>(Loan Extended)</strong></td>';
                
                echo '<td>'.$ext['loanDate'].'</td>';
                echo '<td>'.$ext['dueDate'].'</td>';
                echo '</tr>';
            }
        }
        ?>
        </table>
        <?php } ?>
        
        <?php
        # to remove extended items from return session list
        if (isset($_SESSION['receipt_record']['return']) AND isset($_SESSION['receipt_record']['extend'])) {
            foreach ($_SESSION['receipt_record']['extend'] as $key => $value) {
                if ($_SESSION['receipt_record']['extend'][$key]['itemCode'] == $_SESSION['receipt_record']['return'][$key]['itemCode']) {
                    unset($_SESSION['receipt_record']['return'][$key]);
                }
            }
        }
        ?>

        <!-- RETURN -->
        <?php if (isset($_SESSION['receipt_record']['return']) AND (count($_SESSION['receipt_record']['return']) != 0)) { ?>
        <div class="receiptHeader">Type of Transaction: <?php echo __('Return'); ?> (<?php echo mt_rand(000000000, 999999999); ?>)</div>
        <hr size="1" noshade="noshade" />
        <table width="100%">
        <tr><td>Code</td><td>Title</td><td>Return</td><td>Ovd.</td></tr>
        <?php        
        foreach ($_SESSION['receipt_record']['return'] as $ret) {
            echo '<tr>';
            echo '<td>'.$ret['itemCode'].'</td>';
            echo '<td>'.substr($ret['title'], 0, $receipt_titleLength);
            if (strlen($ret['title']) > $receipt_titleLength) {
                echo ' ...';
            }
            echo '.</td>';
            echo '<td>'.$ret['returnDate'].'</td>';
            if ($ret['overdues']) {
                echo '<td>'.$ret['overdues']['days'].' days overdue</td>';
            } else  {
                echo '<td>&nbsp;</td>';
            }
            echo '</tr>';
        }
        ?>
        </table>
        <?php } ?>
    </div>
    <hr size="1" noshade="noshade" />
    <table width="100%">
        <tr>
            <td width="50%" align="center">Library Staf<br /><br /><?php echo $_SESSION['realname']; ?></td>
            <td width="50%" align="center">Library member<br /><br /><?php echo $_SESSION['receipt_record']['memberName']; ?></td>
        </tr>
    </table>
</div>
<?php $buffer_receipt = ob_get_contents(); ob_end_clean(); echo $buffer_receipt; ?>
<script type="text/javascript">window.print()</script>
<?php
/* main content end */
$content = ob_get_clean();
// include the page template
require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
?>
