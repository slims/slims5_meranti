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
require MODULES_BASE_DIR.'membership/member_base_lib.inc.php';
require MODULES_BASE_DIR.'circulation/circulation_base_lib.inc.php';

// page title
$page_title = 'Member Loan List';

// start the output buffering
ob_start();
?>
<!--loan specific javascript functions-->
<script type="text/javascript">
function confirmProcess(intLoanID, strItemCode, strProcess)
{
    if (strProcess == 'return') {
        var confirmBox = confirm('<?php echo __('Are you sure you want to return the item'); ?> ' + strItemCode);
    } else {
        var confirmBox = confirm('<?php echo __('Are you sure to extend loan for'); ?> ' + strItemCode); //mfc
    }

    if (confirmBox) {
        // fill the hidden form value
        document.loanHiddenForm.process.value = strProcess;
        document.loanHiddenForm.loanID.value = intLoanID;
        // submit hidden form
        document.loanHiddenForm.submit();
    }
}
</script>
<!--loan specific javascript functions end-->
<?php
// check if there is member ID
if (isset($_SESSION['memberID'])) {
    $memberID = trim($_SESSION['memberID']);
    $circulation = new circulation($dbs, $memberID);
    $loan_list_query = $dbs->query("SELECT L.loan_id, b.title, i.item_code, L.loan_date, L.due_date, L.return_date, L.renewed FROM loan AS L
        LEFT JOIN item AS i ON L.item_code=i.item_code
        LEFT JOIN mst_coll_type AS ct ON i.coll_type_id=ct.coll_type_id
        LEFT JOIN member AS m ON L.member_id=m.member_id
        LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
        WHERE L.is_lent=1 AND L.is_return=0 AND L.member_id='$memberID'");

    // create table object
    $loan_list = new simbio_table();
    $loan_list->table_attr = 'align="center" width="100%" cellpadding="3" cellspacing="0"';
    $loan_list->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    $loan_list->highlight_row = true;
    // table header
    $headers = array(__('Return'), __('Extend'), __('Item Code'), __('Title'), __('Loan Date'), __('Due Date'));
    $loan_list->setHeader($headers);
    // row number init
    $row = 1;
    while ($loan_list_data = $loan_list_query->fetch_assoc()) {
        // alternate the row color
        $row_class = ($row%2 == 0)?'alterCell':'alterCell2';

        // return link
        $return_link = '<a href="#" onclick="confirmProcess('.$loan_list_data['loan_id'].', \''.$loan_list_data['item_code'].'\', \'return\')" title="'.__('Return this item').'" class="returnLink">&nbsp;</a>';
        // extend link
        // check if membership already expired
        if ($_SESSION['is_expire']) {
            $extend_link = '<span class="noExtendLink" title="'.__('No Extend').'">&nbsp;</span>';
        } else {
            // check if this loan just already renewed
            if ($loan_list_data['return_date'] == date('Y-m-d')) {
                $extend_link = '<span class="noExtendLink" title="'.__('No Extend').'">&nbsp;</span>';
            } else if (in_array($loan_list_data['loan_id'], $_SESSION['reborrowed'])) {
                $extend_link = '<span class="noExtendLink" title="'.__('No Extend').'">&nbsp;</span>';
            } else {
                $extend_link = '<a href="#" onclick="confirmProcess('.$loan_list_data['loan_id'].', \''.$loan_list_data['item_code'].'\', \'extend\')" title="'.__('Extend loan for this item').'" class="extendLink">&nbsp;</a>';
            }
        }
        // renewed flag
        if ($loan_list_data['renewed'] > 0) {
            $loan_list_data['title'] = $loan_list_data['title'].' - <strong style="color: blue;">'.__('Extended').'</strong>';
        }
        // check for overdue
        $curr_date = date('Y-m-d');
        $overdue = $circulation->countOverdueValue($loan_list_data['loan_id'], $curr_date);
        if ($overdue) {
            $loan_list_data['title'] .= '<div style="color: red; font-weight: bold;">'.__('OVERDUED for').' '.$overdue['days'].' '.__('days(s) with fines value').' '.$overdue['value'].'</div>'; //mfc
        }
        // row colums array
        $fields = array(
            $return_link,
            $extend_link,
            $loan_list_data['item_code'],
            $loan_list_data['title'],
            $loan_list_data['loan_date'],
            $loan_list_data['due_date']
            );

        // append data to table row
        $loan_list->appendTableRow($fields);
        // set the HTML attributes
        $loan_list->setCellAttr($row, null, "valign='top' class='$row_class'");
        $loan_list->setCellAttr($row, 0, "valign='top' align='center' class='$row_class' style='width: 5%;'");
        $loan_list->setCellAttr($row, 1, "valign='top' align='center' class='$row_class' style='width: 5%;'");
        $loan_list->setCellAttr($row, 2, "valign='top' class='$row_class' style='width: 10%;'");
        $loan_list->setCellAttr($row, 3, "valign='top' class='$row_class' style='width: 55%;'");

        $row++;
    }

    // show reservation alert if any
    if (isset($_GET['reserveAlert']) AND !empty($_GET['reserveAlert'])) {
        $reservedItem = trim($_GET['reserveAlert']);
        // get reservation data
        $reserve_q = $dbs->query('SELECT r.member_id, m.member_name
            FROM reserve AS r
            LEFT JOIN member AS m ON r.member_id=m.member_id
            WHERE item_code=\''.$reservedItem.'\' ORDER BY reserve_date DESC');
        $reserve_d = $reserve_q->fetch_row();
        $member = $reserve_d[1].' ('.$reserve_d[0].')';
        $reserve_msg = str_replace(array('{itemCode}', '{member}'), array('<b>'.$reservedItem.'</b>', '<b>'.$member.'</b>'), __('Item {itemCode} is being reserved by member {member}')); //mfc
        echo '<div class="infoBox">'.$reserve_msg.'</div>';
    }
    echo $loan_list->printTable();
    // hidden form for return and extend process
    echo '<form name="loanHiddenForm" method="post" action="circulation_action.php"><input type="hidden" name="process" value="return" /><input type="hidden" name="loanID" value="" /></form>';
}

// get the buffered content
$content = ob_get_clean();
// include the page template
require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
?>
