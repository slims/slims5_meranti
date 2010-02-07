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

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';

// page title
$page_title = 'Loan Receipt';

// start the output buffer
ob_start();
/* main content */
?>
<style type="text/css">
#receiptBody {
  margin: 5px;
  padding: 5px;
  color: #000;
  font-family: serif;
  width: 8cm;
  border: 1px dashed #000;
}

#receiptBody * {
  color: #000;
  font-family: serif;
  font-size: 7pt;
}

.receiptHeader {
  font-weight: bold;
  font-size: 8pt;
}

table td {
  vertical-align: top;
}
</style>
<div id="receiptBody">
    <div id="receiptTitle"><?php echo $sysconf['library_name'] ?><br /><?php echo $sysconf['library_subname'] ?></div>
    <hr />
    <div id="receiptInfo">
        <div id="receiptMember"><?php echo $_SESSION['receipt_record']['memberName'] ?> <?php echo $_SESSION['receipt_record']['memberID'] ?></div>
        <div id="receiptDate"><?php echo $_SESSION['receipt_record']['date'] ?></div>

        <!-- LOAN -->
        <?php if (isset($_SESSION['receipt_record']['loan']) || isset($_SESSION['receipt_record']['extend'])) { ?>
        <div class="receiptHeader"><?php echo __('Loan'); ?></div>
        <hr size="1" noshade="noshade" />
        <table width="100%">
        <tr><td>Code</td><td>Title</td><td>Loan</td><td>Due</td></tr>
        <?php
        foreach ($_SESSION['receipt_record']['loan'] as $loan) {
            echo '<tr>';
            echo '<td>'.$loan['itemCode'].'</td>';
            echo '<td>'.substr($loan['title'], 0, 50).'...</td>';
            echo '<td>'.$loan['loanDate'].'</td>';
            echo '<td>'.$loan['dueDate'].'</td>';
            echo '</tr>';
        }
        // loan extend
        if (isset($_SESSION['receipt_record']['extend'])) {
            foreach ($_SESSION['receipt_record']['extend'] as $ext) {
                echo '<tr>';
                echo '<td>'.$ext['itemCode'].'</td>';
                echo '<td>'.substr($ext['title'], 0, 50).'...<br />-- extended --</td>';
                echo '<td>'.$ext['loanDate'].'</td>';
                echo '<td>'.$ext['dueDate'].'</td>';
                echo '</tr>';
            }
        }
        ?>
        </table>
        <?php } ?>

        <!-- RETURN -->
        <?php if (isset($_SESSION['receipt_record']['return'])) { ?>
        <div class="receiptHeader"><?php echo __('Return'); ?></div>
        <hr size="1" noshade="noshade" />
        <table width="100%">
        <tr><td>Code</td><td>Title</td><td>Return</td><td>Ovd.</td></tr>
        <?php
        foreach ($_SESSION['receipt_record']['return'] as $ret) {
            echo '<tr>';
            echo '<td>'.$ret['itemCode'].'</td>';
            echo '<td>'.substr($ret['title'], 0, 50).'...</td>';
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
</div>
<script type="text/javascript">window.print()</script>
<?php
/* main content end */
$content = ob_get_clean();
// include the page template
require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
?>
