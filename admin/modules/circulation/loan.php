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

/* loan list iframe content */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';

if (!isset($_SESSION['memberID'])) { die(); }

require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_date.inc.php';

// page title
$page_title = 'Member Loan List';

// start the output buffering
ob_start();
// check if there is member ID
if (isset($_SESSION['memberID'])) {
    $memberID = trim($_SESSION['memberID']);
    ?>
    <!--item loan form-->
    <div style="padding: 5px; background: #CCCCCC;">
        <form name="itemLoan" id="loanForm" action="circulation_action.php" method="post" style="display: inline;">
            <?php echo __('Insert Item Code/Barcode'); ?> :
            <input type="text" id="tempLoanID" name="tempLoanID" />
            <input type="submit" value="<?php echo __('Loan'); ?>" class="button" />
        </form>
    </div>
    <script type="text/javascript">$('tempLoanID').focus();</script>
    <!--item loan form end-->
    <?php
    // make a list of temporary loan if there is any
    if (count($_SESSION['temp_loan']) > 0) {
        // create table object
        $temp_loan_list = new simbio_table();
        $temp_loan_list->table_attr = "align='center' style='width: 100%;' cellpadding='3' cellspacing='0'";
        $temp_loan_list->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
        $temp_loan_list->highlight_row = true;
        // table header
        $headers = array(__('Remove'),  __('Item Code'), __('Title'), __('Loan Date'), __('Due Date'));
        $temp_loan_list->setHeader($headers);
        // row number init
        $row = 1;
        foreach ($_SESSION['temp_loan'] as $temp_loan_list_data) {
            // alternate the row color
            $row_class = ($row%2 == 0)?'alterCell':'alterCell2';

            // remove link
            $remove_link = '<a href="circulation_action.php?removeID='.$temp_loan_list_data['item_code'].'" title="Remove this item" class="trashLink">&nbsp;</a>';
            // row colums array
            $fields = array(
                $remove_link,
                $temp_loan_list_data['item_code'],
                $temp_loan_list_data['title'],
                $temp_loan_list_data['loan_date'],
                $temp_loan_list_data['due_date']
                );

            // append data to table row
            $temp_loan_list->appendTableRow($fields);
            // set the HTML attributes
            $temp_loan_list->setCellAttr($row, null, "valign='top' class='$row_class'");
            $temp_loan_list->setCellAttr($row, 0, "valign='top' align='center' class='$row_class' style='width: 5%;'");
            $temp_loan_list->setCellAttr($row, 1, "valign='top' class='$row_class' style='width: 10%;'");
            $temp_loan_list->setCellAttr($row, 2, "valign='top' class='$row_class' style='width: 60%;'");

            $row++;
        }

        echo $temp_loan_list->printTable();
    }

}

// get the buffered content
$content = ob_get_clean();
// include the page template
require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
?>
